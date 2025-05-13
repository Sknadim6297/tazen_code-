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
    public function index()
    {
        $requestedProfessionals = Professional::with('professionalRejection')->where('status', 'pending')->get();
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
