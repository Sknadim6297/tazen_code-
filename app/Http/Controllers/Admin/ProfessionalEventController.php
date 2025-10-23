<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllEvent;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalEventController extends Controller
{
    /**
     * Display a listing of professional events for admin review.
     */
    public function index(Request $request)
    {
        $query = AllEvent::with(['professional.professionalServices.service', 'approvedBy'])
            ->where('created_by_type', 'professional');

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('heading', 'like', "%{$search}%")
                  ->orWhere('mini_heading', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('professional', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Handle export requests
        if ($request->filled('export')) {
            return $this->export($query, $request->export);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => AllEvent::where('created_by_type', 'professional')->count(),
            'pending' => AllEvent::where('created_by_type', 'professional')->where('status', 'pending')->count(),
            'approved' => AllEvent::where('created_by_type', 'professional')->where('status', 'approved')->count(),
            'rejected' => AllEvent::where('created_by_type', 'professional')->where('status', 'rejected')->count(),
        ];

        return view('admin.professional-events.index', compact('events', 'stats'));
    }

    /**
     * Display the specified professional event for review.
     */
    public function show(AllEvent $event)
    {
        // Ensure this is a professional event
        if ($event->created_by_type !== 'professional') {
            abort(404, 'Event not found.');
        }

        $event->load(['professional', 'approvedBy']);

        return view('admin.professional-events.show', compact('event'));
    }

    /**
     * Approve a professional event.
     */
    public function approve(AllEvent $event)
    {
        if ($event->created_by_type !== 'professional') {
            return redirect()->back()->with('error', 'Only professional events can be approved.');
        }

        $event->update([
            'status' => 'approved',
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now(),
            'admin_notes' => null,
        ]);

        return redirect()->back()->with('success', 'Event approved successfully! It will now be visible on the website.');
    }

    /**
     * Reject a professional event.
     */
    public function reject(Request $request, AllEvent $event)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        if ($event->created_by_type !== 'professional') {
            return redirect()->back()->with('error', 'Only professional events can be rejected.');
        }

        $event->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => null,
        ]);

        return redirect()->back()->with('success', 'Event rejected successfully. The professional has been notified.');
    }

    /**
     * Show form to edit a professional event as admin.
     */
    public function edit(AllEvent $event)
    {
        if ($event->created_by_type !== 'professional') {
            abort(404, 'Event not found.');
        }

        return view('admin.professional-events.edit', compact('event'));
    }

    /**
     * Update a professional event as admin.
     */
    public function update(Request $request, AllEvent $event)
    {
        if ($event->created_by_type !== 'professional') {
            abort(404, 'Event not found.');
        }

        $request->validate([
            'card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:1000',
            'starting_fees' => 'required|numeric|min:0',
        ]);

        $updateData = $request->except(['card_image']);

        // Handle file upload if new image is provided
        if ($request->hasFile('card_image')) {
            // Delete old image
            if ($event->card_image) {
                \Storage::disk('public')->delete($event->card_image);
            }
            
            $updateData['card_image'] = $request->file('card_image')->store('professional-events', 'public');
        }

        $event->update($updateData);

        return redirect()->route('admin.professional-events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Delete a professional event.
     */
    public function destroy(AllEvent $event)
    {
        if ($event->created_by_type !== 'professional') {
            abort(404, 'Event not found.');
        }

        // Delete the image file
        if ($event->card_image) {
            \Storage::disk('public')->delete($event->card_image);
        }

        $event->delete();

        return redirect()->route('admin.professional-events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Handle bulk actions for professional events.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'events' => 'required|array|min:1',
            'events.*' => 'exists:all_events,id',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $action = $request->action;
        $eventIds = $request->events;
        $adminNotes = $request->admin_notes;
        $adminId = Auth::guard('admin')->id();

        $events = AllEvent::whereIn('id', $eventIds)
            ->where('created_by_type', 'professional')
            ->get();

        $successCount = 0;
        $errorCount = 0;

        foreach ($events as $event) {
            try {
                if ($action === 'approve') {
                    $event->update([
                        'status' => 'approved',
                        'approved_by' => $adminId,
                        'approved_at' => now(),
                        'admin_notes' => $adminNotes,
                    ]);
                } elseif ($action === 'reject') {
                    $event->update([
                        'status' => 'rejected',
                        'admin_notes' => $adminNotes ?: 'Rejected via bulk action',
                        'approved_by' => $adminId,
                        'approved_at' => null,
                    ]);
                }
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
            }
        }

        $message = ucfirst($action) . "d {$successCount} event(s) successfully.";
        if ($errorCount > 0) {
            $message .= " {$errorCount} event(s) failed.";
        }

        return redirect()->route('admin.professional-events.index')
            ->with('success', $message);
    }

    /**
     * Update meet link for an event
     */
    public function updateMeetLink(Request $request, AllEvent $event)
    {
        $request->validate([
            'meet_link' => 'nullable|url|max:255'
        ]);

        $event->update([
            'meet_link' => $request->meet_link
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meet link updated successfully'
        ]);
    }

    /**
     * Export professional events
     */
    private function export($query, $format)
    {
        $events = $query->get();
        
        if ($format === 'excel') {
            return $this->exportToExcel($events);
        } elseif ($format === 'pdf') {
            return $this->exportToPDF($events);
        }
        
        return redirect()->back();
    }

    /**
     * Export to Excel
     */
    private function exportToExcel($events)
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="professional-events-' . date('Y-m-d') . '.xlsx"',
        ];

        $callback = function() use ($events) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding
            fwrite($file, "\xEF\xBB\xBF");
            
            // Headers
            fputcsv($file, [
                'ID',
                'Professional Name',
                'Professional Email',
                'Event Heading',
                'Mini Heading',
                'Short Description',
                'Event Date',
                'Starting Fees',
                'Meet Link',
                'Status',
                'Created At',
                'Approved At',
                'Admin Notes'
            ]);

            // Data
            foreach ($events as $event) {
                fputcsv($file, [
                    $event->id,
                    $event->professional->name ?? 'N/A',
                    $event->professional->email ?? 'N/A',
                    $event->heading,
                    $event->mini_heading,
                    $event->short_description,
                    $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d') : 'N/A',
                    $event->starting_fees,
                    $event->meet_link ?? 'N/A',
                    ucfirst($event->status),
                    $event->created_at->format('Y-m-d H:i:s'),
                    $event->approved_at ? $event->approved_at->format('Y-m-d H:i:s') : 'N/A',
                    $event->admin_notes ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to PDF
     */
    private function exportToPDF($events)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.professional-events.pdf-export', compact('events'));
        
        return $pdf->download('professional-events-' . date('Y-m-d') . '.pdf');
    }
}
