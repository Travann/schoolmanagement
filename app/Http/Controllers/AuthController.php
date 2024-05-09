<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        $data['header_title'] = "Admin Login";
        if (!empty(Auth::check())) {
            return redirect('admin/dashboard');
        }
        return view('auth.login', $data);
    }
    public function AuthLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

            switch (Auth::user()->user_type) {
                case 1:
                    return redirect('admin/dashboard');
                    break;
                case 2:
                    return redirect('teacher/dashboard');
                    break;
                case 3:
                    return redirect('student/dashboard');
                    break;
                case 4:
                    return redirect('parent/dashboard');
                    break;
                default:
                    return redirect()->back()->with('error', 'Invalid user type.');
                    break;
            }
        } else {
            return redirect()->back()->with('error', 'Incorrect email or password');
        }
    }

    public function forgetpassword()
    {
        $data['header_title'] = "Forget Password";
        return view('auth.forget', $data);
    }
    public function PostForgetPassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
            return redirect()->back()->with('success', "Please check your email and reset your password");
        } else {
            return redirect()->back()->with('error', "Email not found in the system.");
        }
    }
    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
        if (!empty($user)) {
            $data['header_title'] = "Reset Password";
            $data['user'] = $user;
            return view('auth.reset', $data);
        }
    }
    public function PostReset($token, Request $request)
    {
        if ($request->password == $request->cpassword) {
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect(url(''))->with('success', "Password successfully change");
        } else {
            return redirect()->back()->with('error', "Password and confirm password does not match");
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
