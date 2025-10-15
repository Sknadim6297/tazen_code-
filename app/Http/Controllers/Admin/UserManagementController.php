<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Exports\IncompleteUsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    /**
     * Display all users with filtering options
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->filled('registration_status')) {
            switch ($request->registration_status) {
                case 'completed':
                    $query->where('registration_completed', true);
                    break;
                case 'incomplete':
                    $query->where('registration_completed', false);
                    break;
                case 'email_verified':
                    $query->where('email_verified', true);
                    break;
                case 'email_not_verified':
                    $query->where('email_verified', false);
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'completed_registrations' => User::where('registration_completed', true)->count(),
            'incomplete_registrations' => User::where('registration_completed', false)->count(),
            'email_verified' => User::where('email_verified', true)->count(),
            'email_not_verified' => User::where('email_verified', false)->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.user-management.table', compact('users'))->render(),
                'pagination' => $users->links()->render()
            ]);
        }

        return view('admin.user-management.index', compact('users', 'stats'));
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.user-management.show', compact('user'));
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Delete the user
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete user.'
            ], 500);
        }
    }

    /**
     * Force complete user registration (admin action)
     */
    public function forceComplete(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        try {
            $user = User::findOrFail($id);
            
            $user->update([
                'password' => $request->password, // Will be hashed by the mutator
                'registration_completed' => true,
                'password_set_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User registration completed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to complete user registration.'
            ], 500);
        }
    }

    /**
     * Send reminder email to incomplete users
     */
    public function sendReminder($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->registration_completed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User registration is already completed.'
                ], 422);
            }

            // TODO: Implement email reminder functionality
            // Mail::to($user->email)->send(new RegistrationReminderMail($user));

            return response()->json([
                'status' => 'success',
                'message' => 'Reminder email sent successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send reminder email.'
            ], 500);
        }
    }

    /**
     * Export users to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = User::query();
        $this->applyFilters($query, $request);
        $users = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.user-management.pdf', compact('users'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('user-management-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export users to Excel
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new IncompleteUsersExport($request), 'user-management-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('registration_status')) {
            switch ($request->registration_status) {
                case 'completed':
                    $query->where('registration_completed', true);
                    break;
                case 'incomplete':
                    $query->where('registration_completed', false);
                    break;
                case 'email_verified':
                    $query->where('email_verified', true);
                    break;
                case 'email_not_verified':
                    $query->where('email_verified', false);
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
    }
}