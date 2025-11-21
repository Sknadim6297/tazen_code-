<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\AllEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfessionalEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professional = Auth::guard('professional')->user();
        $events = AllEvent::where('professional_id', $professional->id)
            ->where('created_by_type', 'professional')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $statistics = [
            'total' => AllEvent::where('professional_id', $professional->id)->where('created_by_type', 'professional')->count(),
            'pending' => AllEvent::where('professional_id', $professional->id)->where('created_by_type', 'professional')->where('status', 'pending')->count(),
            'approved' => AllEvent::where('professional_id', $professional->id)->where('created_by_type', 'professional')->where('status', 'approved')->count(),
            'rejected' => AllEvent::where('professional_id', $professional->id)->where('created_by_type', 'professional')->where('status', 'rejected')->count(),
        ];
        
        return view('professional.events.index', compact('events', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professional.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $professional = Auth::guard('professional')->user();
        
        $request->validate([
            'card_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:1000',
            'starting_fees' => 'required|numeric|min:0',
        ]);
        $imagePath = null;
        if ($request->hasFile('card_image')) {
            $imagePath = $request->file('card_image')->store('professional-events', 'public');
        }
        $event = AllEvent::create([
            'professional_id' => $professional->id,
            'card_image' => $imagePath,
            'date' => $request->date,
            'time' => $request->time,
            'mini_heading' => $request->mini_heading,
            'heading' => $request->heading,
            'short_description' => $request->short_description,
            'starting_fees' => $request->starting_fees,
            'status' => 'pending',
            'created_by_type' => 'professional',
        ]);

        return redirect()
            ->route('professional.event-details.create', ['event_id' => $event->id])
            ->with('success', 'Event created successfully! Add the detailed information next.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AllEvent $event)
    {
        $professional = Auth::guard('professional')->user();
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event.');
        }
        
        return view('professional.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AllEvent $event)
    {
        $professional = Auth::guard('professional')->user();
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event.');
        }
        if ($event->status === 'approved') {
            return redirect()->route('professional.events.show', $event)
                ->with('error', 'Cannot edit approved events. Please contact admin if changes are needed.');
        }
        
        return view('professional.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AllEvent $event)
    {
        $professional = Auth::guard('professional')->user();
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event.');
        }
        if ($event->status === 'approved') {
            return redirect()->route('professional.events.show', $event)
                ->with('error', 'Cannot edit approved events. Please contact admin if changes are needed.');
        }

        $request->validate([
            'card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:1000',
            'starting_fees' => 'required|numeric|min:0',
        ]);

        $updateData = [
            'date' => $request->date,
            'time' => $request->time,
            'mini_heading' => $request->mini_heading,
            'heading' => $request->heading,
            'short_description' => $request->short_description,
            'starting_fees' => $request->starting_fees,
        ];
        if ($request->hasFile('card_image')) {
            if ($event->card_image) {
                Storage::disk('public')->delete($event->card_image);
            }
            
            $updateData['card_image'] = $request->file('card_image')->store('professional-events', 'public');
        }
        if ($event->status === 'rejected') {
            $updateData['status'] = 'pending';
            $updateData['admin_notes'] = null;
        }

        $event->update($updateData);

        return redirect()->route('professional.events.index')
            ->with('success', 'Event updated successfully! It will be reviewed by admin again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AllEvent $event)
    {
        $professional = Auth::guard('professional')->user();
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event.');
        }
        if ($event->status === 'approved') {
            return redirect()->route('professional.events.index')
                ->with('error', 'Cannot delete approved events. Please contact admin if removal is needed.');
        }
        if ($event->card_image) {
            Storage::disk('public')->delete($event->card_image);
        }

        $event->delete();

        return redirect()->route('professional.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}