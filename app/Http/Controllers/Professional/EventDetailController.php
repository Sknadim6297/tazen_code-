<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDetail;
use App\Models\AllEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventDetailController extends Controller
{
    public function index()
    {
        $professional = Auth::guard('professional')->user();
        
        // Get all event details for events created by this professional
        $eventdetails = EventDetail::with('event')
            ->whereHas('event', function($query) use ($professional) {
                $query->where('created_by_type', 'professional')
                      ->where('professional_id', $professional->id);
            })
            ->latest()
            ->get();
        
        // Get professional's events that don't have details yet
        $eventsWithoutDetails = AllEvent::where('created_by_type', 'professional')
            ->where('professional_id', $professional->id)
            ->whereDoesntHave('eventDetails')
            ->get();
        
        return view('professional.event-details.index', compact('eventdetails', 'eventsWithoutDetails'));
    }

    public function create()
    {
        $professional = Auth::guard('professional')->user();
        
        // Get professional's events that don't have details yet
        $availableEvents = AllEvent::where('created_by_type', 'professional')
            ->where('professional_id', $professional->id)
            ->whereDoesntHave('eventDetails')
            ->get();
        
        return view('professional.event-details.create', compact('availableEvents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:all_events,id',
            'banner_image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'event_type' => 'required|string|max:255',
            'event_details' => 'required|string',
            'starting_date' => 'required|date',
            'starting_fees' => 'required|numeric|min:0',
            'event_gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'city' => 'required_if:event_mode,offline|nullable|string|max:255',
            'event_mode' => 'required|in:online,offline'
        ]);

        $professional = Auth::guard('professional')->user();

        // Verify the event belongs to this professional
        $event = AllEvent::where('id', $request->event_id)
            ->where('created_by_type', 'professional')
            ->where('professional_id', $professional->id)
            ->first();

        if (!$event) {
            return redirect()->back()->withErrors(['event_id' => 'Event not found or you do not have permission to add details to this event.']);
        }

        $data = $request->only([
            'event_id',
            'event_type',
            'event_details',
            'starting_date',
            'starting_fees',
            'city',
            'event_mode'
        ]);

        // Add creator information
        $data['creator_type'] = 'professional';
        $data['creator_id'] = $professional->id;

        // Handle banner images
        if ($request->hasFile('banner_image')) {
            $bannerImages = [];
            foreach ($request->file('banner_image') as $image) {
                $bannerImages[] = $image->store('events/banners', 'public');
            }
            $data['banner_image'] = json_encode($bannerImages);
        }

        // Handle gallery images
        if ($request->hasFile('event_gallery')) {
            $galleryImages = [];
            foreach ($request->file('event_gallery') as $image) {
                $galleryImages[] = $image->store('events/gallery', 'public');
            }
            $data['event_gallery'] = json_encode($galleryImages);
        }

        EventDetail::create($data);

        return redirect()->route('professional.event-details.index')
            ->with('success', 'Event details created successfully.');
    }

    public function show(EventDetail $eventDetail)
    {
        $professional = Auth::guard('professional')->user();
        
        // Check if this event detail belongs to the professional
        if ($eventDetail->creator_type !== 'professional' || $eventDetail->creator_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event detail.');
        }
        
        return view('professional.event-details.show', compact('eventDetail'));
    }

    public function edit(EventDetail $eventDetail)
    {
        $professional = Auth::guard('professional')->user();
        
        // Check if this event detail belongs to the professional
        if ($eventDetail->creator_type !== 'professional' || $eventDetail->creator_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event detail.');
        }
        
        return view('professional.event-details.edit', compact('eventDetail'));
    }

    public function update(Request $request, EventDetail $eventDetail)
    {
        $professional = Auth::guard('professional')->user();
        
        // Check if this event detail belongs to the professional
        if ($eventDetail->creator_type !== 'professional' || $eventDetail->creator_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event detail.');
        }

        $request->validate([
            'event_id' => 'required|exists:all_events,id',
            'banner_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'event_type' => 'required|string|max:255',
            'event_details' => 'required|string',
            'starting_date' => 'required|date',
            'starting_fees' => 'required|numeric|min:0',
            'event_gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'city' => 'required_if:event_mode,offline|nullable|string|max:255',
            'event_mode' => 'required|in:online,offline'
        ]);

        $data = $request->only([
            'event_id',
            'event_type',
            'event_details',
            'starting_date',
            'starting_fees',
            'city',
            'event_mode'
        ]);

        // Handle banner images
        if ($request->hasFile('banner_image')) {
            // Delete old banner images
            if ($eventDetail->banner_image) {
                foreach (json_decode($eventDetail->banner_image) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $bannerImages = [];
            foreach ($request->file('banner_image') as $image) {
                $bannerImages[] = $image->store('events/banners', 'public');
            }
            $data['banner_image'] = json_encode($bannerImages);
        }

        // Handle gallery images
        if ($request->hasFile('event_gallery')) {
            // Delete old gallery images
            if ($eventDetail->event_gallery) {
                foreach (json_decode($eventDetail->event_gallery) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $galleryImages = [];
            foreach ($request->file('event_gallery') as $image) {
                $galleryImages[] = $image->store('events/gallery', 'public');
            }
            $data['event_gallery'] = json_encode($galleryImages);
        }

        $eventDetail->update($data);

        return redirect()->route('professional.event-details.index')
            ->with('success', 'Event details updated successfully.');
    }

    public function destroy(EventDetail $eventDetail)
    {
        $professional = Auth::guard('professional')->user();
        
        // Check if this event detail belongs to the professional
        if ($eventDetail->creator_type !== 'professional' || $eventDetail->creator_id !== $professional->id) {
            abort(403, 'Unauthorized access to this event detail.');
        }

        // Delete associated images
        if ($eventDetail->banner_image) {
            foreach (json_decode($eventDetail->banner_image) as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        if ($eventDetail->event_gallery) {
            foreach (json_decode($eventDetail->event_gallery) as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $eventDetail->delete();

        return redirect()->route('professional.event-details.index')
            ->with('success', 'Event details deleted successfully.');
    }
}
