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
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		if(request()->route()->uri == 'download-apk'){
			
		}else{
			$this->middleware('auth');
		}
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	 
	public function show($id)
	{
		$id = Crypt::decrypt($id);
		dd('show');
		$user = User::findOrFail($id);
		
		$projects = [];
		 
		return view('users.show', compact('user','projects'));
	}

	public function downloadApk()
	{
		$filePath = public_path('apk_files/dwm.apk'); 
		if (file_exists($filePath)) {
			return response()->download($filePath);
		} else {
			return response()->json(['error' => 'File not found'], 404);
		}
	}	

	public function edit($id)
	{
		$id = Crypt::decrypt($id); 
		$condtiions = [];
		$userNameList=$userEmailList=[];
		$condtiions = [];
		$userNameList=$userEmailList=[];
		$projects = [];
		if(auth()->user()->role == 'admin'){
			$projects = Project::latest()->pluck("title","id");
		}else{
			$projects_id = auth()->user()->projects_id;
			$projects_id = json_decode($projects_id);
			$projects = Project::whereIn('id',$projects_id)->latest()->pluck("title","id");	
		} 
		$worksheet = Worksheet::findOrFail($id); // Fetch worksheet by ID or throw 404
		return view('worksheets.edit', compact('worksheet','projects'));
	}


    public function auth_dashboard()
    {
       dd('auth_dashboard');
    }

    public function index()
    {
		$worksheets = 0;
		if(auth()->user()->role == 'admin'){ 
			$worksheets = Worksheet::count(); 
		}else{
			$worksheets = auth()->user()->worksheets()->count();  
		} 
		$counter['worksheets'] = $worksheets;
		$counter['projects'] = Project::count();
		$counter['users'] = User::count();
        return view('home',compact('counter'));
    }
    public function employee_register()
    {
		$projects = Project::latest()->pluck("title","id");
        return view('home.employee_register',compact('projects'));
    } 
	
	public function employee_listing(Request $request) { 
		
		$roleList=$this->master('role');
		$qRaw2 = $qRaw3 =$qRaw4 = 1;
		$condition=null;
		$data=$request->all();
		if($request->all()){
			
			if(@$request->mobile){
				$condition=['mobile'=>@$request->mobile];
			}
			if(@$request->email){
				$condition=['email'=>@$request->email];
			}
			if(@$request->projects_id){
				$qRaw2="  projects_id like '%" . implode(",",@$request->projects_id)."%'";
			}
			if(@$request->role){
				$qRaw3="  role like '%" . implode(",",@$request->role)."%'";
			}
			
			if(@$request->name){
				$qRaw4=" name like '%" . @$request->name."%'";
			}
			
		}
		
		$users = User::where($condition)->whereRaw($qRaw2)->whereRaw($qRaw4)->whereRaw($qRaw3)->latest()->paginate(10); 
		$projects = Project::latest()->pluck("title","id");
		return view('home.employee_listing', compact('users','projects','roleList','data'));
	} 
	
	public function employee_store(Request $request) { 
		$request->validate([
			'projects_id' => ['required'],
			'name' => ['required', 'string', 'max:255'],
			'mobile' => ['required', 'digits:10'],
			'email' => [
				'required', 
				'string', 
				'email', 
				'max:255',
				Rule::unique('users')->whereNull('deleted_at')  // Exclude soft-deleted users
			],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]); 
		
		$data = ($request->all());
		User::create([
			'projects_id' => json_encode($data['projects_id']),
			'name' => $data['name'],
			'email' => $data['email'],
			'mobile' => $data['mobile'],
			'password' => Hash::make($data['password']),
			'role' => $data['role'] ?? 'employee', // Assign 'user' role by default
		]);  
		return redirect('home/employee_listing')->with('success', 'Registration has been successfully.');
	}
	
	public function destroy($id)
	{
		$id = Crypt::decrypt($id);
		$user = User::findOrFail($id);
		$user->delete(); // Soft Delete worksheet
		return redirect('home/employee_listing')->with('success', 'Staff profile has been deleted successfully!');
	}
	
	public function staffedit($id,Request $request){
		$id = Crypt::decrypt($id);
		if(auth()->user()->role == 'admin'){
			$projects = Project::latest()->pluck("title","id");
		}else{
			$projects_id = auth()->user()->projects_id;
			$projects_id = json_decode($projects_id);
			$projects = Project::whereIn('id',$projects_id)->latest()->pluck("title","id");	
		} 
		$userData=User::findOrFail($id);
		if(count($request->all()) > 0) {
		$request->validate([
			'projects_id' => ['required'],
			'name' => ['required', 'string', 'max:255'],
			'mobile' => ['required', 'digits:10'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
		]);
		@$data =$request->all();
		 
			$updateData=['projects_id' =>json_encode($data['projects_id']),
			'name' => $data['name'],
			'email' => $data['email'],'mobile'=>$data['mobile']];
			User::where('id',$id)->update($updateData);
			return redirect()->route('home.employee_listing')->with('success',"Staff Details has been updated successfully.");
		}
		
		if(empty(@$userData)){
			return redirect()->back()->with('error','User Not Found.');
		}
		
		
		return view('home.employee_register_edit',compact('projects','userData'));
	}
	
	public function change_password($id,Request $request){
		$id = Crypt::decrypt($id);
		$userData=User::findOrFail($id);
		if(empty(@$userData)){
			return redirect()->back()->with('error','Staff Not Found.');
		}
		
		if(count($request->all())){
			$request->validate([
				'password' => ['required', 'string', 'min:8', 'confirmed'],
			]); 
			$data= $request->all();
			$updateData=['password' => Hash::make($data['password'])];
			User::where('id',$id)->update($updateData);
			return redirect()->route('home.employee_listing')->with('success',"Staff Details has been updated successfully.");
			
		}
		
		return view('home.change_password',compact('userData'));
	}
	
	
}
