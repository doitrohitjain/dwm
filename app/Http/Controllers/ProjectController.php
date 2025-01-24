<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProjectController extends Controller
{
    public function index()
    {
		$masterActive=$this->master('active');
		$projects = Project::latest()->paginate(10);
        return view('projects.index', compact('projects','masterActive'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Project::create($request->all());
        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function show($id)
    {
		$id = Crypt::decrypt($id);
		$project = Project::findOrFail($id); // Fetch worksheet by ID or throw 404
        return view('projects.show', compact('project'));
    }

    public function edit($id)
    {
		$id = Crypt::decrypt($id);
		$project = Project::findOrFail($id); // Fetch worksheet by ID or throw 404
		
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project->update($request->all());
        return redirect()->route('projects.index')->with('success', 'Project Details has been updated successfully.');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
		$project = Project::findOrFail($id);
		$project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
