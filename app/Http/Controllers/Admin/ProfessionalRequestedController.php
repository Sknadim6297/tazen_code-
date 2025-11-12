<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ProfessionalApproved;
use App\Mail\ProfessionalRejectedMail;
use App\Models\Professional;
use App\Models\ProfessionalRejection;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF as FacadePdf;

class ProfessionalRequestedController extends Controller
{
    public function index(Request $request)
    {
        $query = Professional::where('status', 'pending');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($request->filled('specialization')) {
            $specialization = $request->specialization;
            $query->whereHas('profile', function($q) use ($specialization) {
                $q->where('specialization', $specialization);
            });
        }
        $exportQuery = clone $query;
        $requestedProfessionals = $query->with(['profile', 'professionalRejection'])->latest()->paginate(10);
        $specializations = DB::table('profiles')
            ->select('specialization')
            ->whereNotNull('specialization')
            ->distinct()
            ->orderBy('specialization')
            ->get()
            ->pluck('specialization');
        if ($request->has('export')) {
            $exportData = $exportQuery->with(['profile', 'professionalRejection'])->latest()->get();
            
            if ($request->export === 'excel') {
                return $this->exportToExcel($exportData);
            } elseif ($request->export === 'pdf') {
                return $this->exportToPdf($exportData);
            }
        }

        return view('admin.Requested_professional.index', compact('requestedProfessionals', 'specializations'));
    }

    /**
     * Export data to Excel (CSV format)
     */
    private function exportToExcel($professionals)
    {
        try {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="professionals_requested_' . date('Y_m_d_His') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            
            $callback = function() use ($professionals) {
                $file = fopen('php://output', 'w');
                fputcsv($file, [
                    'ID', 'Name', 'Email', 'Phone', 'Specialization', 
                    'Experience', 'Address', 'Starting Price', 
                    'Status', 'Registration Date', 'Rejection Reason'
                ]);
                foreach ($professionals as $professional) {
                    $rejectionReason = $professional->professionalRejection->first() ? 
                                      $professional->professionalRejection->first()->reason : 'N/A';
                    
                    fputcsv($file, [
                        $professional->id,
                        $professional->name,
                        $professional->email,
                        $professional->phone,
                        $professional->profile ? $professional->profile->specialization : 'Not specified',
                        $professional->profile ? $professional->profile->experience : 'Not specified',
                        $professional->profile ? $professional->profile->address : 'Not specified',
                        $professional->profile ? $professional->profile->starting_price : 'Not specified',
                        ucfirst($professional->status),
                        $professional->created_at->format('d/m/Y'),
                        $rejectionReason
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export data: ' . $e->getMessage());
        }
    }

    /**
     * Export data to PDF
     */
    private function exportToPdf($professionals)
    {
        try {
            $data = [
                'professionals' => $professionals,
                'title' => 'Requested Professionals Report',
            ];
            
            $pdf = FacadePdf::loadView('admin.Requested_professional.professionals', $data);
            return $pdf->download('professionals_requested_' . date('Y_m_d_His') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export data: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        $professional = Professional::findOrFail($id);

        $professional->status = 'accepted';
        $RejectedUser = ProfessionalRejection::where('professional_id', $professional->id)->first();
        if ($RejectedUser) {
            $RejectedUser->delete();
        }
        $professional->save();
        Mail::to($professional->email)->send(new ProfessionalApproved($professional));

        return response()->json([
            'status' => 'success',
            'message' => 'Professional has been approved successfully and notified via email.',
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $professional = Professional::findOrFail($id);
        $professional->status = 'rejected';
        $professional->save();

        ProfessionalRejection::create([
            'professional_id' => $professional->id,
            'admin_id' => auth()->id(),
            'reason' => $request->reason,
        ]);
        Mail::to($professional->email)->send(new ProfessionalRejectedMail($professional, $request->reason));

        return response()->json([
            'status' => 'success',
            'message' => 'Professional has been rejected successfully and notified via email.',
        ]);
    }
    
    public function show($id)
    {
        $professional = Professional::with('profiles')->findOrFail($id);
        return view('admin.Requested_professional.show', compact('professional'));
    }
}
