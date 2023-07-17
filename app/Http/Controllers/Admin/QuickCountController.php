<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuickCountController extends Controller
{
    public function index(Request $request){
        return view('pages.Qc.index');
    }
}
