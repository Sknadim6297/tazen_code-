<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDetail;
use App\Models\AllEvent;
use Illuminate\Support\Facades\Storage;

class EventDetailsController extends Controller
{
    public function index()
    {
        // Get all event details with their events
        $eventdetails = EventDetail::with(['event'])
            ->latest()
            ->get();
            
        $allevents = AllEvent::latest()->get();
        
        return view('admin.eventdetails.index', compact('eventdetails', 'allevents'));
    }

    public function create()
    {
        return view('admin.eventdetails.create');
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
            'event_gallery.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
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

        // Add creator information for admin
        $data['creator_type'] = 'admin';
        $data['creator_id'] = auth()->guard('admin')->id();

        if ($request->hasFile('banner_image')) {
            $bannerImages = [];
            foreach ($request->file('banner_image') as $image) {
                $bannerImages[] = $image->store('events/banners', 'public');
            }
            $data['banner_image'] = json_encode($bannerImages);
        }
        if ($request->hasFile('event_gallery')) {
            $galleryImages = [];
            foreach ($request->file('event_gallery') as $image) {
                $galleryImages[] = $image->store('events/gallery', 'public');
            }
            $data['event_gallery'] = json_encode($galleryImages);
        }

        EventDetail::create($data);

        return redirect()->route('admin.eventdetails.index')
            ->with('success', 'Event details created successfully.');
    }

    public function show(EventDetail $eventdetail)
    {
        return view('admin.eventdetails.show', compact('eventdetail'));
    }

    public function edit(EventDetail $eventdetail)
    {
        return view('admin.eventdetails.edit', compact('eventdetail'));
    }

    public function update(Request $request, EventDetail $eventdetail)
    {
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
        if ($request->hasFile('banner_image')) {
            if ($eventdetail->banner_image) {
                foreach (json_decode($eventdetail->banner_image) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $bannerImages = [];
            foreach ($request->file('banner_image') as $image) {
                $bannerImages[] = $image->store('events/banners', 'public');
            }
            $data['banner_image'] = json_encode($bannerImages);
        }
        if ($request->hasFile('event_gallery')) {
            if ($eventdetail->event_gallery) {
                foreach (json_decode($eventdetail->event_gallery) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $galleryImages = [];
            foreach ($request->file('event_gallery') as $image) {
                $galleryImages[] = $image->store('events/gallery', 'public');
            }
            $data['event_gallery'] = json_encode($galleryImages);
        }

        $eventdetail->update($data);

        return redirect()->route('admin.eventdetails.index')
            ->with('success', 'Event details updated successfully.');
    }

    public function destroy(EventDetail $eventdetail)
    {
        if ($eventdetail->banner_image) {
            Storage::disk('public')->delete($eventdetail->banner_image);
        }
        if ($eventdetail->event_gallery) {
            foreach (json_decode($eventdetail->event_gallery) as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $eventdetail->delete();

        return redirect()->route('admin.eventdetails.index')
            ->with('success', 'Event details deleted successfully.');
    }
}
