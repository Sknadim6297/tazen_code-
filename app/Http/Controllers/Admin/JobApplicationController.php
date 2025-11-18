<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = JobApplication::with('career')->latest()->get();
        return view('admin.job-applications.index', compact('applications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = JobApplication::with('career')->findOrFail($id);
        return view('admin.job-applications.show', compact('application'));
    }

    /**
     * Update the status of the application.
     */
    public function updateStatus(Request $request, string $id)
    {
        $application = JobApplication::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.job-applications.index')->with('success', 'Application status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = JobApplication::findOrFail($id);
        
        // Delete associated files
        if ($application->cv_resume && \Storage::disk('public')->exists($application->cv_resume)) {
            \Storage::disk('public')->delete($application->cv_resume);
        }
        if ($application->cover_letter_file && \Storage::disk('public')->exists($application->cover_letter_file)) {
            \Storage::disk('public')->delete($application->cover_letter_file);
        }
        
        $application->delete();

        return redirect()->route('admin.job-applications.index')->with('success', 'Application deleted successfully.');
    }
}
