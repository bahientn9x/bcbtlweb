<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
	function __construct(){
		$this->middleware('auth:users');
	}

    public function index()
    {
    	return view('admin.dashboard');
    }
}
