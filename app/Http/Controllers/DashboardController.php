<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->user_type == 1) {
            $data['header_title'] = "Admin Dashboard";
            return view('admin.dashboard', $data);
        } else if (Auth::user()->user_type == 2) {
            $data['header_title'] = "Teacher Dashboard";
            return view('teacher.dashboard', $data);
        } else if (Auth::user()->user_type == 3) {
            $data['header_title'] = "Student Dashboard";
            return view('student.dashboard', $data);
        } else if (Auth::user()->user_type == 4) {
            $data['header_title'] = "Parent Dashboard";
            return view('parent.dashboard', $data);
        }
    }
}
