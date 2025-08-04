<?php

namespace App\Http\Controllers\authDocs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function create(){
    
        return view('docs.login'); // 
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'),true)) {
            $request->session()->regenerate();
            return redirect()->route('documents.index')->with('status', 'Login successful, welcome back!');
        }
    }
        
}
