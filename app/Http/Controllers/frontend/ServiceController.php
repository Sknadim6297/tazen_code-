<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Service;

class ServiceController extends Controller
{
    public function show(Service $service)
    {
        $service->load('detail');
        
        $testimonials = Testimonial::latest()->get();
        $services = Service::latest()->get();
        
        if (!$service) {
            abort(404, 'Service not found.');
        }
        $metaTitle = $service->meta_title ?: $service->name . ' - Professional Services';
        $metaDescription = $service->meta_description ?: 'Find professional ' . strtolower($service->name) . ' services. Connect with verified experts and book appointments easily.';

        return view('frontend.sections.service', compact('service', 'testimonials', 'services', 'metaTitle', 'metaDescription'));
    }
}
