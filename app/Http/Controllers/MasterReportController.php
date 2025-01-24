<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Worksheet;
use App\Models\User;
use Illuminate\Http\Request;

class MasterReportController extends Controller
{
    
   public function index(){ 
        // Fetch all reports with the admin who generated them
        $reports = Report::with('generatedBy')->latest()->paginate(10);
		
        return view('reports.index', compact('reports'));
    } 
	public function downloadExcel(Request $request) {
		$request->validate([
			'start_date' => 'required|date',
			'end_date' => 'required|date|after_or_equal:start_date',
		]);

		$worksheets = Worksheet::whereBetween('date', [$request->start_date, $request->end_date])
							   ->get();
		dd($worksheets);
		return redirect()->back()->with('success', 'Report Excel has been exported successfully.');
	}  
}
