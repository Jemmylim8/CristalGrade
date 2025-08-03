<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->classes;
        return view('student.classes', compact('classes'));
    }
}
