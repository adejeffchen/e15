<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * GET /
     * Show the application welcome page
     */
    public function index()
    {
        # If we land on this page after doing a search, we'll have the following data available
        $searchResults = session('searchResults', null);

        return view('pages/welcome', [
            'searchResults' => $searchResults,
        ]);
    }

    /**
     * GET /support
     * Show the support page
     */
    public function support()
    {
        return view('pages/support');
    }
}