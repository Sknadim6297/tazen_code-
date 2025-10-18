<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AllEventController extends Controller
{
    public function index(Request $request)
    {
        $query = AllEvent::with(['professional', 'approvedBy']);
        $filter = $request->get('filter', 'all');
        
        switch ($filter) {
            case 'admin':
                $query->where('created_by_type', 'admin');
                break;
            case 'professional':
                $query->where('created_by_type', 'professional');
                break;
            case 'pending':
                $query->where('status', 'pending');
                break;
            case 'all':
            default:
                break;
        }
        $allevents = $query->orderBy('created_at', 'desc')->paginate(15);
            
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
}
