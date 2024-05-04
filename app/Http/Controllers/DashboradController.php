<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class DashboradController extends Controller
{
    public function index()
    {
        $data = Companies::all();
        return view('mail.registercompany', compact('data'));
        // return view('dashboard', compact('data'));
    }
}
