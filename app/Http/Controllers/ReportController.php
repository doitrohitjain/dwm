<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use App\Models\Worksheet;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\WorksheetsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	 
	public function indexwithsorting(Request $request)
    {  
		$reports = Report::with('generatedBy')->latest()->paginate(10);
		$userNameWithMobileList = $userNameList=$userMobileList=$userEmailList=[];
		$projects = $worksheets = [];
		//Session::flash('success', 'This is a message!'); 
		
		$conditions=null; 
		$qRaw2 = $qRaw3 = 1;
		$start_date = $end_date = date("Y-m-d");
		$inputs=[];
		$inputs = $request->all();
		if(@$inputs['start_date']){
		}else{
			$inputs['start_date'] = $start_date;
		}
		
		if(@$inputs['end_date']){
		}else{
			$inputs['end_date'] = $end_date;
		}
		
		if($request->all()){
			
			$user_id = @$request->user_id;
			$projects_id = @$request->projects_id;
			if(@$user_id){  
				$tempUserIds = User::whereIn('id',$user_id)->pluck('id');
				if(count($tempUserIds) > 0){
					$tempUserIds = $tempUserIds->toArray();
					$qRaw2 = "  user_id in (" . implode(",",$tempUserIds).")";
				} 
			} 
			if(@$projects_id){
				$tempProjectIds = Project::whereIn('id',$projects_id)->pluck('id');
				if(count($tempProjectIds) > 0){
					$tempProjectIds = $tempProjectIds->toArray();
					$qRaw3 = "  project_id in (" . implode(",",$tempProjectIds).")";
				}
			}
			$start_date =  @$request->start_date;
			$end_date =  @$request->end_date;
		} 
		$query = null;
		if(auth()->user()->role == 'admin'){
			$projects = Project::latest()->pluck("title","id");
			$userNameList = User::pluck('name','id'); 
			$userEmailList = User::pluck('email','id'); 
			$userMobileList = User::pluck('mobile','id');
			$userNameWithMobileList = User::where('role','employee')->get()->mapWithKeys(function ($user) {
				return [$user->id => "{$user->name} ({$user->mobile})"];
			});  
			// $worksheets = Worksheet::whereRaw($qRaw2)
			// ->whereRaw($qRaw3)
			// ->where($conditions)
			// ->whereBetween('date', [$start_date, $end_date])->latest()->paginate(10);


			$query =  Worksheet::whereRaw($qRaw2)
				->whereRaw($qRaw3)
				->where($conditions)
				->whereBetween('date', [$start_date, $end_date]); 
			// dd($start_date);
			 

		}else{
			$projects_id = auth()->user()->projects_id;
			$projects_id = json_decode($projects_id);
			if(@$projects_id){
				$projects = Project::whereIn('id',$projects_id)->latest()->pluck("title","id");
			}
			$query = auth()->user()->worksheets()->whereRaw($qRaw2)
			->whereRaw($qRaw3)
			->where($conditions)
			->whereBetween('date', [$start_date, $end_date]);  
		}   
		
		$sortBy = $request->input('sort_by', 'id'); 			
		$direction = $request->input('direction', 'desc'); 
		$query->orderBy($sortBy, $direction); 
		$worksheets = $query->paginate(10); // Adjust number per page as needed
		// dd($sortBy);
			
			
		// Append the request data to pagination links
		$worksheets->appends($inputs);
        return view('reports.indexwithsorting', compact('direction','sortBy','inputs','reports','projects','userEmailList','userNameWithMobileList','userNameList','userMobileList','worksheets'));
    }
	public function index(Request $request)
    {  
		$reports = Report::with('generatedBy')->latest()->paginate(10);
		$userNameWithMobileList = $userNameList=$userMobileList=$userEmailList=[];
		$projects = $worksheets = [];
		//Session::flash('success', 'This is a message!'); 
		
		$conditions=null; 
		$qRaw2 = $qRaw3 = 1;
		$start_date = $end_date = date("Y-m-d");
		$inputs=[];
		$inputs = $request->all();
		if(@$inputs['start_date']){
		}else{
			$inputs['start_date'] = $start_date;
		}
		
		if(@$inputs['end_date']){
		}else{
			$inputs['end_date'] = $end_date;
		}
		
		if($request->all()){
			
			$user_id = @$request->user_id;
			$projects_id = @$request->projects_id;
			if(@$user_id){  
				$tempUserIds = User::whereIn('id',$user_id)->pluck('id');
				if(count($tempUserIds) > 0){
					$tempUserIds = $tempUserIds->toArray();
					$qRaw2 = "  user_id in (" . implode(",",$tempUserIds).")";
				} 
			} 
			if(@$projects_id){
				$tempProjectIds = Project::whereIn('id',$projects_id)->pluck('id');
				if(count($tempProjectIds) > 0){
					$tempProjectIds = $tempProjectIds->toArray();
					$qRaw3 = "  project_id in (" . implode(",",$tempProjectIds).")";
				}
			}
			$start_date =  @$request->start_date;
			$end_date =  @$request->end_date;
		} 
		
		if(auth()->user()->role == 'admin'){
			$projects = Project::latest()->pluck("title","id");
			$userNameList = User::pluck('name','id'); 
			$userEmailList = User::pluck('email','id'); 
			$userMobileList = User::pluck('mobile','id');
			$userNameWithMobileList = User::where('role','employee')->get()->mapWithKeys(function ($user) {
				return [$user->id => "{$user->name} ({$user->mobile})"];
			});  
			$worksheets = Worksheet::whereRaw($qRaw2)
			->whereRaw($qRaw3)
			->where($conditions)
			->whereBetween('date', [$start_date, $end_date])->latest()->paginate(10); 


		}else{
			$projects_id = auth()->user()->projects_id;
			$projects_id = json_decode($projects_id);
			if(@$projects_id){
				$projects = Project::whereIn('id',$projects_id)->latest()->pluck("title","id");
			}
			$worksheets = auth()->user()->worksheets()->whereRaw($qRaw2)
			->whereRaw($qRaw3)
			->where($conditions)
			->whereBetween('date', [$start_date, $end_date])->latest()->paginate(10);  
		}   
		// Append the request data to pagination links
		$worksheets->appends($inputs);
        return view('reports.index', compact('inputs','reports','projects','userEmailList','userNameWithMobileList','userNameList','userMobileList','worksheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    
	public function downloadExcel(Request $request) {
		$request->validate([
			'start_date' => 'required|date',
			'end_date' => 'required|date|after_or_equal:start_date',
		]);
		if(auth()->user()->role == 'admin'){
			
		}else{
			$conditions['user_id'] = auth()->user()->id;
		}
		$querys['start_date'] = $request->start_date;
		$querys['end_date'] = $request->end_date;
		$querys['name'] = @$request->name;
		$querys['email'] = @$request->email;
		$querys['user_id'] = @$request->user_id;
		$querys['mobile'] = @$request->mobile;
		$querys['projects_id'] = null;
		
		if(@$request->projects_id[0] && $request->projects_id[0] != null){
			$querys['projects_id'] = @$request->projects_id;
		}
		
		$fileName = 'worksheet_' . $request->start_date . "_". $request->end_date ;
		
		return Excel::download(new WorksheetsExport($querys),$fileName.'_' . date("d-m-Y") .'.xlsx');
		 
		// $worksheets = Worksheet::whereBetween('date', [$request->start_date, $request->end_date])
							   // ->get(); 
							   
		// dd($worksheets);
		// return redirect()->back()->with('success', 'Report Excel has been exported successfully.');
	}
	
	
	public function employee_listing() { 
		echo "sdfasdf";die;
		// $users = User::paginate(10);
		// dd($users);
		// return view('reports.employee_listing', compact('users'));
	}
	
	public function store(Request $request) {
		$request->validate([
			'start_date' => 'required|date',
			'end_date' => 'required|date|after_or_equal:start_date',
		]);
		
		$worksheets = Worksheet::whereBetween('date', [$request->start_date, $request->end_date])
							   ->get();

		$reportDetails = $worksheets->groupBy('user_id')->map(function ($tasks, $userId) {
			return [
				'user' => User::find($userId)->name,
				'tasks' => $tasks->count(),
				'completed' => $tasks->where('status', 'completed')->count(),
			];
		});

		Report::create([
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'generated_by' => auth()->id(),
			'details' => $reportDetails->toJson(),
		]);

		return redirect()->back()->with('success', 'Report generated successfully.');
	}


    /**
     * Display the specified resource.
     */
    public function show(Report $report,$id)
    {
        // Fetch the report along with the admin who generated it
        $report = Report::with('generatedBy')->findOrFail($id);

        // Pass the report details to the view
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
	
	
	public function queryediter(Request $request){ 
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
		$inputs['sql'] = "show tables;";
		$isValidSqlResponse = $this->_checkIsValidSql($inputs['sql']);
		dd($isValidSqlResponse);
	
        $query = null;
	    if(!empty($request->queryediter)){
            $query = $statement = $request->queryediter;    		
        }else if(!empty($request->query_back)){
            $query = $statement = $request->query_back; 
			
			return view('reports.queryediter',compact('query'));  		
        }else{
			return view('reports.queryediter',compact('query'));  	
        }
        // Get connection object and set the charset
        $host = env('DB_HOST'); 
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $name = env('DB_DATABASE');
		
		
		// echo  $host .'-'.$user.'-'.$pass.'-'.$name;die;
		
		// $host = "10.68.128.254";
		// $user = "hteapp";
		// $pass = "hteapp@123";
		// $name = "daily-worksheet-manager";
		
		
		try { 
            DB::statement("SET SESSION wait_timeout = 28800");
            DB::statement("SET SESSION interactive_timeout = 28800");
            $result = DB::select($query); 
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        } 
		 
        // $conn->set_charset("utf8");
        $sqlScript = "";
        $response = null;
        $inputs['sql'] = $query;
        // $isValidSqlResponse = $this->_checkIsValidSql($inputs['sql']);
		$isValidSqlResponse['status'] = true;
        if(!$isValidSqlResponse['status'] && !empty($isValidSqlResponse['errors'])){
            return redirect()->back()->withInput($request->all())->with('error', 'Error : ' . $isValidSqlResponse['errors']);;
        }   

        if(!empty($statement)){
            $query = $statement . " ;";
        }
        // $result = mysqli_query($conn, $query);
		$result = DB::select($query);
        echo ' <script>
        function copyToClipboard(elem) {
            elem.focus();
            elem.select(); 
            document.execCommand("copy");
            }
        </script>';
        if (isset($result) && !empty($result)) {
            
			$row_cnt = @$result->num_rows;
			$userData = array('text' => $query,'result_counts' => $row_cnt, 'status' => '1','errorr'=> '');
			
            echo '<br>';
            echo '<br> 
            SQL Query  : <span>' . $query. '</span> <br><br><input type="text" onClick="copyToClipboard(this)" style="width: 20%;" value="' . $query .'" id="myInput">';

            echo '<br><br> Total Records Count : ';
            echo $row_cnt;
            echo '<br><br> ';

            

            if (@$result->num_rows > 0) {
				Session::put('query_get_alls', $query); 
				 //$get = Session::put('query_get_alls',$query);
                 // @dd($get);

               echo "<form method='post' action=" . route('queryediter') .">
                <input type='hidden' name='query_back' value='". $query ."'>
				<input type='hidden' name='_token' value='". csrf_token() ."'>
				<button type='submit' class='buttonY'>Please Click Here To Try Again New</button>
                </form>";
                
            echo '<br>';
                echo '<input type=button value="Copy Result" class="button" onClick="copytable()">';
				
				//session set 
				echo "<a class='button' style='background-color:blue;' href='" . route('querydownloadexcel',$query)."'>Download Excel</a>";
                echo '<script type="text/javascript"> 
                function copytable(el) {
                    el = "stats";
                    var urlField = document.getElementById(el)   
                    var range = document.createRange()
                    range.selectNode(urlField)
                    window.getSelection().addRange(range) 
                    document.execCommand("copy")
                }
                
                </script> <style>

				.buttonY{
					background: linear-gradient(45deg,#e4ad12,#d3ce31)!important;
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
				}
				.button {
                    background-color: #4CAF50; /* Green */
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
                  }
                  </style>';


               
                echo '<span id="pwd_spn" class="password-span">';
                echo "<table border='1' id=stats>";
                $counter = 0;
                $fields = array();
                while ($row = @$result->fetch_array()) {

                    $counterMax = count($row);
                    $counterMaxFinal = $counterMax / 2;

                    if ($counter == 0) {
                        echo "<tr>";
                        $tempRow = array_keys($row);
                        $tempRowCount = count(array_keys($row));
                        $tempCounter = 0;
                        $rCount = 0;
                        for ($r = 0; $r < $tempRowCount; $r++) {
                            if ($tempCounter % 2 != 0) {
                                $fields[] = $tempRow[$r];
                            }
                            $tempCounter++;
                            $rCount++;
                        }
                        echo "<pre>Fields Name List : ";print_r($fields);
                        echo "<br>"; 
                        $fieldsCounter = count($fields);
                        foreach ($fields as $keyTemp => $valueTemp) {
                            echo "<th>";
                            if (isset($valueTemp)) {
                                echo $valueTemp;
                            }
                            echo "</th>";
                        }
                        echo "</tr>";
                    }

                    echo "<tr>";

                    for ($r = 0; $r < $counterMaxFinal; $r++) {
                        echo "<td>";
                        if (isset($row[$r])) {
                            echo $row[$r];
                        }
                        echo "</td>";
                    }
                    // print_r($row);
                    $counter++;
                    echo "</tr>";
                }

                echo "</table>";
                echo "</span>";
            } else {
                echo "Completed or 0 results";
				echo "<h2><a href='" . route('queryediter') . "' >Please Click Here To Try Again New</a></h2>";
				echo '<br>';
            }
        } else {
            echo 'According To System Your entered wrong Query : ';
            echo '<br>';
            echo '<br> Error Is : ';
            echo mysqli_error($conn);
            echo '<br>';
            echo '<br> 
            SQL Query  : <span>' . $query. '</span> <br><br><input type="text" onClick="copyToClipboard(this)" style="width: 20%;" value="' . $query .'" id="myInput">';

            echo '<br>';
            echo '<br>
            <style>
            
            </style>
           ' 
            ;

            echo '<br>';


			$userData = array('text' => $query, 'status' => '0','errorr'=> mysqli_error($conn));
            
            echo "<h2><a href='" . route('queryediter') . "' >Please Click Here To Try Again New</a></h2>";
            echo '<br>';
        }
		// MasterQuery::create($userData);
		// $conn->close();
        die;
	}
}
