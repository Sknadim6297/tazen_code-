<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AllEvent;
use App\Models\EventFAQ;

class EventController extends Controller
{
    /**
     * Display all approved events (admin + professional)
     */
    public function index()
    {
        $events = AllEvent::where('status', 'approved')
            ->with(['professional'])
            ->orderBy('date', 'asc')
            ->paginate(12);
            
        return view('frontend.events', compact('events'));
    }

    /**
     * Display a specific event
     */
    public function show($id)
    {
        $event = AllEvent::where('id', $id)
            ->where('status', 'approved')
            ->with(['professional', 'approvedBy'])
            ->firstOrFail();

        $eventfaqs = EventFAQ::latest()->get();

        return view('frontend.event-details', compact('event', 'eventfaqs'));
    }
}
