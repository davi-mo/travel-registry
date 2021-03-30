<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home() : View
    {
        $user = User::find(auth()->user()->id);
        return view("home")->with("user", $user);
    }
}
