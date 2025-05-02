<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professional;

class ProfessionalRequestedController extends Controller
{
    public function index()
    {
        $requestedProfessionals = Professional::where('status', 'pending')->get();
        return view('admin.Requested_professional.index', compact('requestedProfessionals'));
    }
    public function approve($id)
    {
        $professional = Professional::findOrFail($id);
        $professional->status = 'accepted';
        $professional->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Professional has been approved successfully.',
        ]);
    }

    public function reject($id)
    {
        $professional = Professional::findOrFail($id);
        $professional->status = 'rejected';
        $professional->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Professional has been rejected successfully.',
        ]);
    }
    public function show($id)
    {
        $professional = Professional::with('profiles')->findOrFail($id);
        return view('admin.Requested_professional.show', compact('professional'));
    }
}
