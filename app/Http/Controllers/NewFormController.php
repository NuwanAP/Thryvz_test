<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewFormController extends Controller
{
    public function index()
    {
        return view('form.index');
    }

    public function submitForm(Request $request)
    {
        // return response()->json(['message' => 'Form submitted successfully'], 200);
    }
}
