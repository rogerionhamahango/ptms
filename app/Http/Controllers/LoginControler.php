<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginControler extends Controller
{
    public function login0()
    {
        return view('auth.login');
    }
}
