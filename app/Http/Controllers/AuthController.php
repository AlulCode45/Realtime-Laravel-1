<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view("login");
    }
    public function loginProcess(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('chats')->with('success', 'Login successful');
        } else {
            return back()->withInput()->with('error', 'Login failed, please check your credentials');
        }
    }
}
