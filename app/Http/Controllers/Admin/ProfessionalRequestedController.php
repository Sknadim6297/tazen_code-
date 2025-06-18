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
use App\Exports\ProfessionalsExport;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ProfessionalRequestedController extends Controller
{
    public function index(Request $request)
    {
        $query = Professional::where('status', 'pending');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Specialization filter
        if ($request->filled('specialization')) {
            $specialization = $request->specialization;
            $query->whereHas('profile', function($q) use ($specialization) {
                $q->where('specialization', $specialization);
            });
        }

        // Fetch filtered professionals with their profiles
        $requestedProfessionals = $query->with(['profile', 'professionalRejection'])->latest()->get();
        
        // Get all unique specializations from profiles table for the dropdown
        $specializations = DB::table('profiles')
            ->select('specialization')
            ->whereNotNull('specialization')
            ->distinct()
            ->orderBy('specialization')
            ->get()
            ->pluck('specialization');

        // Handle export requests
        if ($request->has('export')) {
            if ($request->export === 'excel') {
                return $this->exportToExcel($requestedProfessionals);
            } elseif ($request->export === 'pdf') {
                return $this->exportToPdf($requestedProfessionals);
            }
        }

        return view('admin.Requested_professional.index', compact('requestedProfessionals', 'specializations'));
    }

    /**
     * Export data to Excel
     */
    private function exportToExcel($professionals)
    {
        $filename = 'professionals_' . date('Y_m_d_His') . '.xlsx';
        return Excel::download(new ProfessionalsExport($professionals), $filename);
    }

    /**
     * Export data to PDF
     */
    private function exportToPdf($professionals)
    {
        $data = [
            'professionals' => $professionals,
            'title' => 'Professional Requests Report'
        ];
        
        $pdf = FacadePdf::loadView('admin.Requested_professional.professionals', $data);
        $filename = 'professionals_' . date('Y_m_d_His') . '.pdf';
        
        return $pdf->download($filename);
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

        // Send email
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

        // Send email
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
