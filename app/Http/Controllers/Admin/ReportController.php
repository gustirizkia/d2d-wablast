<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $soal = Soal::with('statistikPilihan.pilihan')->paginate(12);
        // dd($soal);

        return view('pages.report.soal', compact('soal'));
    }
}
