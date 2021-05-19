<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function show()
    {
        //
    }

    public function handle()
    {
        //

        event(new Registered($user));
    }
}
