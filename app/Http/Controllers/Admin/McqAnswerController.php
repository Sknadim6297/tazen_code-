<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\McqAnswer;
use Illuminate\Http\Request;

class McqAnswerController extends Controller
{
    public function index()
    {
        $mcqAnswers = McqAnswer::with(['user', 'service', 'question'])
            ->latest()
            ->get();

        return view('admin.mcq.index', compact('mcqAnswers'));
    }
} 