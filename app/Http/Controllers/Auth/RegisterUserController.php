<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);


        $validated = $request->validate([
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        $hashedpassword = Hash::make($request->password);

        $params = $request->merge(['password' => $hashedpassword]);

        $params = $request->except('_token');

        $user = new User($params);
        $user->save();

        event(new Registered($user));

        return view('backend.user.auth.login');

    } 
}
