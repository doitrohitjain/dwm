<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worksheet;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	public function index() { 
		// dd(auth()->user()->role); 
		$condtiions = [];
		
		$userMobileList=$userNameList=$userEmailList=[];
		$projects = [];
		if(auth()->user()->role == 'admin'){
			$userNameList = User::pluck('name','id'); 
			$userEmailList = User::pluck('email','id'); 
			$userMobileList = User::pluck('mobile','id'); 
			$worksheets = Worksheet::latest()->paginate(10); 
			$projects = Project::latest()->pluck("title","id");
		}else{
			$worksheets = auth()->user()->worksheets()->latest()->paginate(10);
			$projects_id = auth()->user()->projects_id;
			$projects_id = json_decode($projects_id);
			if(@$projects_id){
				$projects = Project::whereIn('id',$projects_id)->latest()->pluck("title","id");	
			}else{ 
			} 
		} 
		return view('worksheets.index', compact('worksheets','userNameList','userMobileList','userEmailList','projects'));
	}

	public function store(Request $request) {
		$request->validate([
			'date' => 'required|date',
			'task' => 'required|string',
			'status' => 'required|string',
			// 'description' => 'required|string',
		]);
		$inputs = $request->all(); 
		auth()->user()->worksheets()->create($inputs);
		return redirect()->back()->with('success', 'Task has been successfully submitted.');
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    } 

    public function show($id)
	{
		$id = Crypt::decrypt($id);
		$worksheet = Worksheet::findOrFail($id); // Fetch worksheet by ID or throw 404
		
		$projects = [];
		if(auth()->user()->role == 'admin'){
			$projects = Project::latest()->pluck("title","id");
		}else{
			$projects_id = auth()->user()->projects_id;
			$projects_id = json_decode($projects_id);
			$projects = Project::whereIn('id',$projects_id)->latest()->pluck("title","id");	
		} 
		
		return view('worksheets.show', compact('worksheet','projects'));
	} 

    /**
     * Show the form for editing the specified resource.
     */
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


   public function update(Request $request, $id)
	{
		$id = Crypt::decrypt($id);
		$request->validate([
			'task' => 'required|string|max:255',
			// 'description' => 'required|string',
			'project_id' => 'required',
			'status' => 'required|in:pending,completed',
		]);

		$worksheet = Worksheet::findOrFail($id);
		$worksheet->update($request->all()); // Update worksheet with validated data

		return redirect()->route('worksheets.index')->with('success', 'Task has been successfully updated.');
	}


    public function destroy($id)
	{
		$id = Crypt::decrypt($id);
		$worksheet = Worksheet::findOrFail($id);
		$worksheet->delete(); // Soft Delete worksheet

		return redirect()->route('worksheets.index')->with('success', 'Task has been deleted successfully.');
	}

}
