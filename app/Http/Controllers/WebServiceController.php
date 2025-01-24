<?php
 
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;


class WebServiceController extends Controller
{
    public function test(){
		echo "test";die;
	}
    public function getProjects()
    {
        $projects = Project::latest()->pluck("title","id");
        return response()->json($projects);
    }
}
