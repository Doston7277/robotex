<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index($lang)
    {
        session(['my_locale' => $lang]);
        return back();
    }

}
