<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ProfessionalApproved;
use App\Mail\ProfessionalRejectedMail;
use App\Models\Professional;
use App\Models\ProfessionalRejection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        // Fetch filtered professionals
        $requestedProfessionals = $query->latest()->get();

        return view('admin.Requested_professional.index', compact('requestedProfessionals'));
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
