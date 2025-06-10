<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Help::query();

        // Apply category filter if selected
        if ($request->has('category_filter') && $request->category_filter != '') {
            $query->where('category', $request->category_filter);
        }

        $helps = $query->latest()->get();
        return view('admin.help.index', compact('helps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.help.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:' . implode(',', Help::CATEGORIES),
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        Help::create($request->all());

        return redirect()->route('admin.help.index')
            ->with('success', 'Help FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Help $help)
    {
        return view('admin.help.show', compact('help'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Help $help)
    {
        return view('admin.help.edit', compact('help'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Help $help)
    {
        $request->validate([
            'category' => 'required|in:' . implode(',', Help::CATEGORIES),
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $help->update($request->all());

        return redirect()->route('admin.help.index')
            ->with('success', 'Help FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Help $help)
    {
        $help->delete();

        return redirect()->route('admin.help.index')
            ->with('success', 'Help FAQ deleted successfully.');
    }

    /**
     * Display the frontend help page.
     */
    public function frontend(Request $request)
    {
        $query = Help::where('status', 'active');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Handle category filter
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $helps = $query->orderBy('category')
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('frontend.sections.help', compact('helps'));
    }
}
