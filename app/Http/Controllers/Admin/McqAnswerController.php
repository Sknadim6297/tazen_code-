<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\McqAnswer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class McqAnswerController extends Controller
{
    public function index(Request $request)
    {
        $query = McqAnswer::with(['user', 'service', 'question']);

        // Apply username filter - works independently
        if ($request->has('username') && !empty(trim($request->username))) {
            $username = trim($request->username);
            $query->whereHas('user', function ($q) use ($username) {
                $q->where('name', 'like', '%' . $username . '%')
                  ->orWhere('email', 'like', '%' . $username . '%');
            });
        }

        // Apply service filter - works independently
        if ($request->has('service') && $request->service != '') {
            $query->where('service_id', $request->service);
        }

        // Apply start date filter - works independently
        if ($request->has('start_date') && !empty($request->start_date)) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        // Apply end date filter - works independently
        if ($request->has('end_date') && !empty($request->end_date)) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        // Get filtered results
        $mcqAnswers = $query->latest()->get();
        
        // Get all services for dropdown
        $services = Service::orderBy('name')->get();

        // Get filter counts for display
        $totalRecords = McqAnswer::count();
        $filteredRecords = $mcqAnswers->count();

        return view('admin.mcq.index', compact('mcqAnswers', 'services', 'totalRecords', 'filteredRecords'));
    }
} 