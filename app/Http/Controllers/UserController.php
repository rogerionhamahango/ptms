<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function user()
    {
        return view('pages.user');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'user_role' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create($validated);

        return redirect()->back()->with('success', 'User created successfully.');
    }
}
