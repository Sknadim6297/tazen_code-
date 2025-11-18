<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'career_id' => 'required|exists:careers,id',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_country' => 'nullable|string|max:10',
                'phone_number' => 'required|string|max:20',
                'compensation_expectation' => 'nullable|string|max:255',
                'why_perfect_fit' => 'nullable|string',
                'cv_resume' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:51200', // 50MB
                'cover_letter_file' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:51200',
                'cover_letter_text' => 'nullable|string',
            ], [
                'career_id.required' => 'Career ID is required.',
                'career_id.exists' => 'Selected job does not exist.',
                'full_name.required' => 'Full name is required.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'phone_number.required' => 'Phone number is required.',
                'cv_resume.required' => 'Please upload your CV or resume.',
                'cv_resume.max' => 'CV file size must not exceed 50MB.',
                'cv_resume.mimes' => 'CV must be a PDF, DOC, DOCX, JPEG, JPG, or PNG file.',
                'cover_letter_file.max' => 'Cover letter file size must not exceed 50MB.',
                'cover_letter_file.mimes' => 'Cover letter must be a PDF, DOC, DOCX, JPEG, JPG, or PNG file.',
            ]);

            $data = [
                'career_id' => $validated['career_id'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone_country' => $validated['phone_country'] ?? null,
                'phone_number' => $validated['phone_number'],
                'compensation_expectation' => $validated['compensation_expectation'] ?? null,
                'why_perfect_fit' => $validated['why_perfect_fit'] ?? null,
                'cover_letter_text' => $validated['cover_letter_text'] ?? null,
                'status' => 'pending',
            ];

            // Handle CV/Resume upload
            if ($request->hasFile('cv_resume')) {
                $data['cv_resume'] = $request->file('cv_resume')->store('job_applications/cv', 'public');
            }

            // Handle Cover Letter file upload
            if ($request->hasFile('cover_letter_file')) {
                $data['cover_letter_file'] = $request->file('cover_letter_file')->store('job_applications/cover_letters', 'public');
            }

            JobApplication::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Your application has been submitted successfully! We will review it and get back to you soon.'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check your inputs.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your application. Please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
}
