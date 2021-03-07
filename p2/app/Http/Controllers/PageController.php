<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $ageSelects = range(18, 75);
        $retiredAgeSelects = range(45, 85);
        return view('home', [
            'ageSelects' => $ageSelects,
            'retiredAgeSelects' => $retiredAgeSelects,
        ]);
    }

    public function calculate(Request $request)
    {
        $ageSelects = range(18, 75);
        $retiredAgeSelects = range(45, 85);

        $currentAge = $request->input('currentAge');

        return view('home', [
            'ageSelects' => $ageSelects,
            'retiredAgeSelects' => $retiredAgeSelects,
            'currentAge' => $currentAge
        ]);
    }
}