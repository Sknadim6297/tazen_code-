<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\Profile;
use Illuminate\Http\Request;

class ManageProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professionals = Professional::with('profiles')->get();
        return view('admin.manage-professional.index', compact('professionals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manage-professional.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profiles = Profile::with('professional')->get();
        return view('admin.manage-professional.show', compact('profiles'));
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
