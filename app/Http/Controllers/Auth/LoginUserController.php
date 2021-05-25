<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginUserController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt(request(['email', 'password']))== false)
        {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }
        else{

            return redirect('/admin/dashboard');
        }

    }
}
