<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function cart()
    {
        return view('pages.cart');
    }
}