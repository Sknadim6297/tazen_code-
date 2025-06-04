<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceMCQ;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceMCQController extends Controller
{
    public function index()
    {
        $mcqs = ServiceMCQ::with('service')->get();
        $services = Service::all();
        $servicemcqs = ServiceMCQ::with('service')->get();
        return view('admin.servicemcq.index', compact('mcqs','services','servicemcqs'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'question' => 'required|string',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
        ]);
    
        // Check if this service already has 5 questions
        $existingCount = ServiceMcq::where('service_id', $request->service_id)->count();
    
        if ($existingCount >= 12) {
            return redirect()->back()->with('error', 'Only 5 questions allowed per service.');
        }
    
        ServiceMcq::create([
            'service_id' => $request->service_id,
            'question' => $request->question,
            'answer1' => $request->answer1,
            'answer2' => $request->answer2,
            'answer3' => $request->answer3,
            'answer4' => $request->answer4,
        ]);
    
        return redirect()->back()->with('success', 'Question added successfully.');
    }
    

    public function show(ServiceMCQ $servicemcq)
    {
        return view('admin.servicemcq.show', compact('servicemcq'));
    }

    public function edit(ServiceMCQ $servicemcq)
    {
        $services = Service::all();
        return view('admin.servicemcq.edit', compact('servicemcq', 'services'));
    }

    public function update(Request $request, ServiceMCQ $servicemcq)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'question' => 'required|string',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
        ]);

        $servicemcq->update($request->all());

        return redirect()->route('admin.servicemcq.index')->with('success', 'MCQ updated successfully.');
    }

    public function destroy(ServiceMCQ $servicemcq)
    {
        $servicemcq->delete();
        return redirect()->route('admin.servicemcq.index')->with('success', 'MCQ deleted.');
    }
}
