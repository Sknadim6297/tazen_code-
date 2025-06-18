<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventFAQ;


class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::findOrFail($id);

        // Find the corresponding event in all_events table
        $allEvent = \App\Models\AllEvent::where('name', $event->name)
            ->orWhere('heading', $event->name)
            ->first();

        // If found, use the ID from all_events
        if ($allEvent) {
            $event->all_event_id = $allEvent->id;
        } else {
        }

        $eventfaqs = EventFAQ::latest()->get();

        return view('frontend.sections.allevent', compact('event', 'eventfaqs')); // Pass event to view
    }
}
