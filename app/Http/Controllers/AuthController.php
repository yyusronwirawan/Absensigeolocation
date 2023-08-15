<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator};

class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status == 1) {
                $request->session()->regenerate();

                return redirect()->intended('dashboard');
            } else {
                return redirect()->back()->withErrors([
                    'username' => 'Akun anda tidak aktif, silahkan hubungi admin kepegawaian di instansi anda',
                ])->onlyInput('username');
            }
        } else {
            return redirect()->back()->withErrors([
                'username' => 'Username atau Password salah',
            ])->onlyInput('username');
        }
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
