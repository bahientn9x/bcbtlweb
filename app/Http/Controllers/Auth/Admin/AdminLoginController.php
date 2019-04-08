<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
    	return view('login');
    }

    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'email' => 'required|email',
    		'password' => 'required',
    	], 
    	[
    		'email.required' => 'Bạn chưa nhập email.',
    		'email.email' => 'Email không đúng.',
    		'password.required' => 'Bạn chưa nhập mật khẩu.',
    	]
    	);

    	if($validator->fails()) {
    		return back()->withInput()->withErrors($validator);
    	}
    	$email = $request->email;
    	$password = $request->password;
    	if(Auth::guard('users')->attempt(['email'=>$email, 'password'=>$password])) {
    		return redirect('admin/dashboard')->with('notify_login','Đăng nhập thành công');
    	}
    	else return back()->withInput()->with('notify_login','Email hoặc mật khẩu không đúng.');
    }

    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect('admin/login');
    }
}
