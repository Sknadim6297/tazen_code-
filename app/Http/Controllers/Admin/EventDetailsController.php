<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDetail;
use Illuminate\Support\Facades\Storage;

class EventDetailsController extends Controller
{
    public function index()
    {
        $eventdetails = EventDetail::latest()->get();
        return view('admin.eventdetails.index', compact('eventdetails'));
    }

    public function create()
    {
        return view('admin.eventdetails.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'event_details' => 'required',
            'starting_date' => 'required|date',
            'starting_fees' => 'required|numeric',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'event_gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['event_name', 'event_type', 'event_details', 'starting_date', 'starting_fees']);

        // Upload banner image
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        // Upload gallery images as JSON
        $galleryImages = [];
        if ($request->hasFile('event_gallery')) {
            foreach ($request->file('event_gallery') as $image) {
                $galleryImages[] = $image->store('events/gallery', 'public');
            }
            $data['event_gallery'] = json_encode($galleryImages);
        }

        EventDetail::create($data);

        return redirect()->route('admin.eventdetails.index')->with('success', 'Event created successfully.');
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
            'event_name' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'event_details' => 'required',
            'starting_date' => 'required|date',
            'starting_fees' => 'required|numeric',
            'banner_image' => 'image|mimes:jpg,jpeg,png,webp',
            'event_gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['event_name', 'event_type', 'event_details', 'starting_date', 'starting_fees']);

        // Update banner image if new one is uploaded
        if ($request->hasFile('banner_image')) {
            if ($eventdetail->banner_image) {
                Storage::disk('public')->delete($eventdetail->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        // Update gallery if new ones uploaded
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

        return redirect()->route('admin.eventdetails.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(EventDetail $eventdetail)
    {
        // Delete banner image and gallery
        if ($eventdetail->banner_image) {
            Storage::disk('public')->delete($eventdetail->banner_image);
        }

        if ($eventdetail->event_gallery) {
            foreach (json_decode($eventdetail->event_gallery) as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $eventdetail->delete();

        return redirect()->route('admin.eventdetails.index')->with('success', 'Event deleted successfully.');
    }
}
