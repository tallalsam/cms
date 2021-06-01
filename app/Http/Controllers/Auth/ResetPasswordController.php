<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\PasswordResetNotification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;


class ResetPasswordController extends Controller
{
    public function validatePasswordRequest(Request $request)
    {
        $user = DB::table('users')->where('email', '=', $request->email)->first();

        //Check if the user exists
        if (count((array)$user) < 1) 
        {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        // DB::table('password_resets')->insert([
        //     'email' => $request->email,
        //     'token' => Str::random(60),
        //     'created_at' => Carbon::now()
        // ]);

        //Get the token just created above
        // $tokenData = DB::table('password_resets')->where('email', $request->email)->first();


        if ($this->sendResetEmail($request->email)) 
        {
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } 
        else 
        {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }

    }

    private function sendResetEmail($email)
    {
        //Retrieve the user from the database
        // $user = DB::table('users')->where('email', $email)->select('username', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        // $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($user->email);


        try 
        {
            //Here send the link with CURL with an external email API 
            // $user->sendPasswordResetNotification($token);

            \Password::broker()->sendResetLink(['email' => $email]);

            // flash('Reset password link sent', 'success');
            // return redirect()->route('admin.users.show', $user);
        
            return true;
        } 
        catch (\Exception $e) 
        {
            return false;
        }
    }

    public function showResetForm()
    {
        return view('backend.user.auth.passwords.reset');
    }


    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required' ]);

        // //check if payload is valid before moving on
        // if ($validator->fails()) 
        // {
        //     return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        // }

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('backend.user.auth.passwords.email');

        $user = User::where('email', $tokenData->email)->first();

        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);

        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();

        //Send Email Reset Success Email
        if ($this->sendSuccessEmail($tokenData->email)) 
        {
            return view('backend.user.dashboard');
        } 
        else 
        {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }
    }
}
