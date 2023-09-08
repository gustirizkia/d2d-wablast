<?php

namespace App\Http\Controllers;

use App\Models\DataTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){

        $count['survey'] = DataTarget::where("user_survey_id", auth()->user()->id)->count();
        $survey = DataTarget::where("user_survey_id", auth()->user()->id)->orderBy('id', 'desc')->limit(8)->get();

        return Inertia::render("Home", compact('count', 'survey'));
    }

    public function welcome(){
        return view('welcome');
    }
}
