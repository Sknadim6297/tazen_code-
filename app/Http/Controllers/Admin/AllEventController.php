<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllEvent;
use Illuminate\Support\Facades\Storage;

class AllEventController extends Controller
{
    public function index()
    {
    $allevents = Allevent::all();
     // Fetch all events
    // $events = EventPost::with('eventDetails')->get();
    return view('admin.allevents.index', compact('allevents'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_image' => 'required|image',
            'date' => 'required|string|max:50',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:255',
            'starting_fees' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('card_image')) {
            $data['card_image'] = $request->file('card_image')->store('allevents', 'public');
        }

        AllEvent::create($data);

        return redirect()->route('admin.allevents.index')->with('success', 'Event added successfully.');
    }

    public function edit(AllEvent $allevent)
    {
        return view('admin.allevents.edit', compact('allevent'));
    }

    public function update(Request $request, AllEvent $allevent)
    {
        $request->validate([
            'date' => 'required|string|max:50',
            'mini_heading' => 'required|string|max:100',
            'heading' => 'required|string|max:150',
            'short_description' => 'required|string|max:255',
            'starting_fees' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('card_image')) {
            if ($allevent->card_image && Storage::disk('public')->exists($allevent->card_image)) {
                Storage::disk('public')->delete($allevent->card_image);
            }
            $data['card_image'] = $request->file('card_image')->store('allevents', 'public');
        }

        $allevent->update($data);

        return redirect()->route('admin.allevents.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(AllEvent $allevent)
    {
        if ($allevent->card_image && Storage::disk('public')->exists($allevent->card_image)) {
            Storage::disk('public')->delete($allevent->card_image);
        }

        $allevent->delete();
        return redirect()->route('admin.allevents.index')->with('success', 'Event deleted successfully.');
    }
}
