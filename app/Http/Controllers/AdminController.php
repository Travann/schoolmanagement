<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = "Admin List";
        return view('admin.admin.list', $data);
    }
    public function add()
    {
        $data['header_title'] = "Add New Admin";
        return view('admin.admin.add', $data);
    }
    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', "Admin successfully create.");
    }
    public function edit($id)
    {
        $data['getRecord'] = User::getSingleAdmin($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Admin";
            return view('admin.admin.edit', $data);
        } else {
            abort(400);
        }
    }
    public function update($id, Request $request)
    {
        $user = User::getSingleAdmin($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', "Admin successfully updated.");
    }
    public function delete($id)
    {
        $user = User::getSingleAdmin($id);
        $user->is_delete = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', "Admin successfully deleted.");
    }
}
