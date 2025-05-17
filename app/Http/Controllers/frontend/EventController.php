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
        dd($event);
        $eventfaqs = EventFAQ::latest()->get();
        
        return view('frontend.sections.allevent', compact('event','eventfaqs')); // Pass event to view
    }
}


