<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceMCQ;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceMCQController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceMCQ::with('service');

        // Apply service filter if selected
        if ($request->has('service_filter') && $request->service_filter != '') {
            $query->where('service_id', $request->service_filter);
        }

        $servicemcqs = $query->latest()->get();
        $services = Service::all();

        return view('admin.servicemcq.index', compact('servicemcqs', 'services'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // Log the incoming request data
            Log::info('ServiceMCQ Store Request:', $request->all());

            $request->validate([
                'service_id' => 'required|exists:services,id',
                'question' => 'required|string',
                'question_type' => 'required|in:text,mcq',
                'options' => 'required_if:question_type,mcq|array',
                'include_other' => 'boolean'
            ]);
        
            // Check if this service already has 12 questions
            $existingCount = ServiceMCQ::where('service_id', $request->service_id)->count();
        
            if ($existingCount >= 12) {
                return redirect()->back()->with('error', 'Maximum 12 questions allowed per service.');
            }
        
            $data = [
                'service_id' => $request->service_id,
                'question' => $request->question,
                'question_type' => $request->question_type,
                'has_other_option' => $request->has('include_other')
            ];

            if ($request->question_type === 'mcq') {
                if (!$request->has('options') || empty($request->options)) {
                    return redirect()->back()->with('error', 'At least one option is required for MCQ questions.');
                }
                
                $options = array_filter($request->options); // Remove empty options
                if (empty($options)) {
                    return redirect()->back()->with('error', 'At least one valid option is required for MCQ questions.');
                }

                if ($request->has('include_other')) {
                    $options[] = 'Other';
                }
                $data['options'] = $options;
            } else {
                // For text questions, set options to null
                $data['options'] = null;
            }

            // Log the data being saved
            Log::info('ServiceMCQ Data to be saved:', $data);
        
            $mcq = ServiceMCQ::create($data);
            
            // Log the created record
            Log::info('ServiceMCQ Created:', ['id' => $mcq->id, 'data' => $mcq->toArray()]);
        
            return redirect()->back()->with('success', 'Question added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating question: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Error creating question: ' . $e->getMessage())->withInput();
        }
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
        try {
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'question' => 'required|string',
                'question_type' => 'required|in:text,mcq',
                'options' => 'required_if:question_type,mcq|array',
                'include_other' => 'boolean'
            ]);

            $data = [
                'service_id' => $request->service_id,
                'question' => $request->question,
                'question_type' => $request->question_type,
                'has_other_option' => $request->has('include_other')
            ];

            if ($request->question_type === 'mcq') {
                $options = $request->options;
                if ($request->has('include_other')) {
                    $options[] = 'Other';
                }
                $data['options'] = $options;
            }

            $servicemcq->update($data);

            return redirect()->route('admin.servicemcq.index')->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating question: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating question: ' . $e->getMessage());
        }
    }

    public function destroy(ServiceMCQ $servicemcq)
    {
        try {
            $servicemcq->delete();
            return redirect()->route('admin.servicemcq.index')->with('success', 'Question deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting question: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting question: ' . $e->getMessage());
        }
    }
}
