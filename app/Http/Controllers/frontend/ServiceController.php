<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\ServiceDetails;

class ServiceController extends Controller
{
    public function show($id)
    {
        $service = Service::with('detail')->findOrFail($id);
        $testimonials = Testimonial::latest()->get();
        $services = Service::latest()->get();
        
        if (!$service) {
            abort(404, 'Service not found.');
        }

        return view('frontend.sections.service', compact('service', 'testimonials', 'services'));
    }
}
