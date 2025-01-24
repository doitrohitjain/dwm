<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Project;
use Illuminate\Validation\Rule;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Crypt;
class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	  
	
	public function staffRegisterValid(Request $request)
	{
		// Get all input data
		$inputs = $request->all();
	
		// Define base validation rules
		$rules = [
			'projects_id' => ['required'],
			'name' => ['required', 'string', 'max:255'],
			'mobile' => [
				'required',
				'digits:10', // Ensuring exactly 10 digits
			],
			'email' => [
				'required',
				'string',
				'email',
				'max:255',
				'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,7}$/', // Validates a proper email format
				Rule::unique('users')->whereNull('deleted_at'), // Exclude soft-deleted users
			],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]; 
		// Custom error messages
		$customMessages = [
			'projects_id.required' => 'The project is required.',
			'name.required' => 'The name is required.',
			'name.string' => 'The name must be a string.',
			'name.max' => 'The name may not be greater than 255 characters.',
			'email.required' => 'The email address is required.',
			'mobile.required' => 'The mobile number is required.',
			'mobile.digits' => 'The mobile number must be 10 digits is required.',
			'email.string' => 'The email address must be a string.',
			'email.email' => 'The email address must be a valid email.',
			'email.max' => 'The email address may not be greater than 255 characters.',
			'email.unique' => 'The email address has already been taken.',
			'password.required' => 'The password is required.',
			'password.string' => 'The password must be a string.',
			'password.min' => 'The password must be at least 8 characters.',
			'password.confirmed' => 'The password confirmation does not match.',
		]; 
		// Validate the data
		$validator = Validator::make($inputs, $rules, $customMessages);
		// Check if validation fails
		if ($validator->fails()) {
			
			// dd($validator->errors());
			// Return validation errors
			return response()->json([
				'status' => 'error',
				'message' => 'Validation failed',
				'errors' => $validator->errors(),
			], 200);
		}

		// If validation passes, return success response
		return response()->json([
			'status' => 'success',
			'message' => 'Staff validated successfully!',
		]);
	}

	public function staffUpdateRegisterValid(Request $request)
	{
		// Get all input data
		$inputs = $request->all();
		$id = Crypt::decrypt($inputs['id']);
		// Define base validation rules
		$rules = [
			'projects_id' => ['required'],
			'name' => ['required', 'string', 'max:255'],
			'mobile' => [
				'required',
				'digits:10', // Ensuring exactly 10 digits
			],
			'email' => [
				'required',
				'string',
				'email',
				'max:255',
				'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,7}$/', // Validates a proper email format
				Rule::unique('users')->whereNull('deleted_at')->where('id','=',$id), // Exclude soft-deleted users
			]
		]; 
		// Custom error messages
		$customMessages = [
			'projects_id.required' => 'The project is required.',
			'name.required' => 'The name is required.',
			'name.string' => 'The name must be a string.',
			'name.max' => 'The name may not be greater than 255 characters.',
			'email.required' => 'The email address is required.',
			'mobile.required' => 'The mobile number is required.',
			'mobile.digits' => 'The mobile number must be 10 digits is required.',
			'email.string' => 'The email address must be a string.',
			'email.email' => 'The email address must be a valid email.',
			'email.max' => 'The email address may not be greater than 255 characters.',
			'email.unique' => 'The email address has already been taken.'
		]; 
		// Validate the data
		$validator = Validator::make($inputs, $rules, $customMessages);
		// Check if validation fails
		if ($validator->fails()) { 
			// Return validation errors
			return response()->json([
				'status' => 'error',
				'message' => 'Validation failed',
				'errors' => $validator->errors(),
			], 200);
		}

		// If validation passes, return success response
		return response()->json([
			'status' => 'success',
			'message' => 'Staff validated successfully!',
		]);
	}


	
	
}
