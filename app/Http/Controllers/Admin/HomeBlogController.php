<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBlog;

class HomeBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeblogs = HomeBlog::all(); // fetch all records
        return view('admin.homeblog.index', compact('homeblogs'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Handle 3 images
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image$i")) {
                $data["image$i"] = $request->file("image$i")->store('homeblogs', 'public');
            }
        }

        HomeBlog::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Home Blog updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
