<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;

class LoginRestController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = users::where('email', $req->email)->first();
    }
}
