<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Exports\AllEventsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AllEventController extends Controller
{
    public function index(Request $request)
    {
        $query = AllEvent::with(['professional.professionalServices.service', 'approvedBy']);
        
        // Filter by creator type
        $filter = $request->get('filter', 'all');
        switch ($filter) {
            case 'admin':
                $query->where('created_by_type', 'admin');
                break;
            case 'professional':
                $query->where('created_by_type', 'professional');
                break;
            case 'all':
            default:
                // Show all events (both admin and professional)
                break;
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('heading', 'like', "%{$search}%")
                  ->orWhere('mini_heading', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('professional', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $allevents = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
            
        return view('admin.allevents.index', compact('allevents'));
    }

    public function create()
    {
        return view('admin.allevents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:1000',
            'starting_fees' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        if ($request->hasFile('card_image')) {
            $data['card_image'] = $request->file('card_image')->store('events', 'public');
        }
        $data['status'] = 'approved';
        $data['created_by_type'] = 'admin';
        $data['approved_by'] = Auth::guard('admin')->id();
        $data['approved_at'] = now();

        AllEvent::create($data);

        return redirect()->route('admin.allevents.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(AllEvent $allevent)
    {
        return view('admin.allevents.show', compact('allevent'));
    }

    public function edit(AllEvent $allevent)
    {
        return view('admin.allevents.edit', compact('allevent'));
    }

    public function update(Request $request, AllEvent $allevent)
    {
        $request->validate([
            'card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:1000',
            'starting_fees' => 'required|numeric|min:0',
        ]);

        $data = $request->except(['card_image']);

        if ($request->hasFile('card_image')) {
            if ($allevent->card_image && Storage::disk('public')->exists($allevent->card_image)) {
                Storage::disk('public')->delete($allevent->card_image);
            }
            $data['card_image'] = $request->file('card_image')->store('events', 'public');
        }

        $allevent->update($data);

        return redirect()->route('admin.allevents.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(AllEvent $allevent)
    {
        if ($allevent->card_image && Storage::disk('public')->exists($allevent->card_image)) {
            Storage::disk('public')->delete($allevent->card_image);
        }

        $allevent->delete();
        
        return redirect()->route('admin.allevents.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Approve a professional event
     */
    public function approve(AllEvent $allevent)
    {
        if ($allevent->isProfessionalEvent()) {
            $allevent->update([
                'status' => 'approved',
                'approved_by' => Auth::guard('admin')->id(),
                'approved_at' => now(),
                'admin_notes' => null,
            ]);
            
            return redirect()->back()->with('success', 'Event approved successfully.');
        }
        
        return redirect()->back()->with('error', 'Only professional events can be approved.');
    }

    /**
     * Reject a professional event
     */
    public function reject(Request $request, AllEvent $allevent)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        if ($allevent->isProfessionalEvent()) {
            $allevent->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes,
                'approved_by' => Auth::guard('admin')->id(),
                'approved_at' => null,
            ]);
            
            return redirect()->back()->with('success', 'Event rejected successfully.');
        }
        
        return redirect()->back()->with('error', 'Only professional events can be rejected.');
    }

    /**
     * Export events to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['filter', 'status', 'from_date', 'to_date', 'search']);
        
        $fileName = 'all-events-' . date('Y-m-d-His') . '.xlsx';
        
        return Excel::download(new AllEventsExport($filters), $fileName);
    }

    /**
     * Export events to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = AllEvent::with(['professional.professionalServices.service', 'approvedBy']);
        
        // Apply same filters as index
        $filter = $request->get('filter', 'all');
        switch ($filter) {
            case 'admin':
                $query->where('created_by_type', 'admin');
                break;
            case 'professional':
                $query->where('created_by_type', 'professional');
                break;
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('heading', 'like', "%{$search}%")
                  ->orWhere('mini_heading', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('professional', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $events = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('admin.allevents.pdf-export', compact('events'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('all-events-' . date('Y-m-d-His') . '.pdf');
    }

    /**
     * Update meet link for an event
     */
    public function updateMeetLink(Request $request, AllEvent $allevent)
    {
        $request->validate([
            'meet_link' => 'nullable|url|max:255'
        ]);

        $allevent->update([
            'meet_link' => $request->meet_link
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meet link updated successfully'
        ]);
    }

    /**
     * Toggle event homepage display
     */
    public function toggleHomepage(Request $request, AllEvent $allevent)
    {
        Log::info('Toggle homepage request received', [
            'event_id' => $allevent->id,
            'current_status' => $allevent->show_on_homepage,
            'requested_status' => $request->show_on_homepage,
            'event_approval_status' => $allevent->status
        ]);

        $request->validate([
            'show_on_homepage' => 'required|boolean'
        ]);

        // Only approved events can be shown on homepage
        if ($request->show_on_homepage && $allevent->status !== 'approved') {
            Log::warning('Attempt to show non-approved event on homepage', [
                'event_id' => $allevent->id,
                'status' => $allevent->status
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Only approved events can be displayed on homepage'
            ]);
        }

        $allevent->update([
            'show_on_homepage' => $request->show_on_homepage
        ]);

        $message = $request->show_on_homepage 
            ? 'Event will now be displayed on homepage'
            : 'Event removed from homepage display';

        Log::info('Homepage display updated successfully', [
            'event_id' => $allevent->id,
            'new_status' => $allevent->show_on_homepage,
            'message' => $message
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
