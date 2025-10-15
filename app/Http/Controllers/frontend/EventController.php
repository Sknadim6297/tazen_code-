<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllEvent;
use App\Models\EventFAQ;

class EventController extends Controller
{
    /**
     * Display all approved events (admin + professional)
     */
    public function index()
    {
        // Get all approved events regardless of who created them
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
        // Get the event by ID and ensure it's approved
        $event = AllEvent::where('id', $id)
            ->where('status', 'approved')
            ->with(['professional', 'approvedBy'])
            ->firstOrFail();

        $eventfaqs = EventFAQ::latest()->get();

        return view('frontend.event-details', compact('event', 'eventfaqs'));
    }
}
