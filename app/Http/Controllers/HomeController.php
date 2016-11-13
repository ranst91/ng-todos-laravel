<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class HomeController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('home');
    }

    public function profile(Request $request) {
        $user = $request->user;
        return view('profile')->with(['user' => $user]);
    }
}
