<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
		$users = User::where('role', 'employee')->get();
		return view('users.index', compact('users'));
	}

}
