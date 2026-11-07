<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecoverPasswordControl extends Controller
{
    public function recoverPassword(){
        return view('pages.recover_password');
    }
}
