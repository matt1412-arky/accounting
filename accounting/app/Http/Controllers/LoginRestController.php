<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginRestController extends Controller
{
    public function login(Request $req)
    {
        // Validasi input email dan password
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = users::where('email', $req->email)->first();

        //jika user ada
        if ($user) {
            // jika akun terkunci
            if ($user->is_locked) {
                return response()->json(['message' => 'Akun terkunci. Silahkan hubungi Admin'], 403);
            }

            // Validasi password
            if ($req->password === $user->password) {
                // jika password cocok, reset login attempt
                $user->login_attempt = 0;
                $user->save();

                //login sukses
                return response()->json(['message' => 'login berhasil'], 200);
            } else {
                //jika password tidak cocok, tambah login attempt
                $user->login_attempt++;
                $user->save();

                // jika sudah melebihi batas percobaan, kunci akun
                if ($user->login_attempt >= 3) {
                    $user->is_locked = true;
                    $user->save();

                    return response()->json(['message' => 'Akun terkunci. Silahkan hubungi admin'], 403);
                }
                return response()->json(['message' => 'Email atau password salah'], 422);
            }
        } else {
            return response()->json(['message' => 'Email atau password tidak valid'], 422);
        }
    }

    public function getCurrentUser($email)
    {
        $user = users::where('email', $email)->first();
        return response()->json([
            'user_id' => $user->id,
            'username' => $user->username,
            'role_id' => $user->role_id,
            'email' => $user->email
        ]);
    }
}
