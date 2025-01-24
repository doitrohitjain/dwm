<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Project;
use App\Models\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorksheetsExport implements FromCollection, WithHeadings
{
    
	function __construct($request) {
		$this->start_date = $request['start_date'];
		$this->end_date = $request['end_date'];
		$this->name = $request['name'];
		$this->email = $request['email'];
		$this->user_id = $request['user_id'];
		$this->mobile = $request['mobile'];
		$this->projects_id = $request['projects_id'];
	} 
	 
    public function collection()
    { 
		$start_date =  $this->start_date;
		$end_date =  $this->end_date;
		$name =  $this->name;
		$projects_id =  $this->projects_id;
		$email =  $this->email;
		$user_id =  $this->user_id;
		$mobile =  $this->mobile;
		$conditions=null;
		$qRaw1 = $qRaw2 = $qRaw3 = 1;
		 
		if(@$name){ 
			$tempUserIds = User::where('name',$name)->pluck('id');
			if(count($tempUserIds) > 0){
				$tempUserIds = $tempUserIds->toArray();
				$qRaw1 = "  user_id in (" . implode(",",$tempUserIds).")";
			} 
		}elseif(@$email){  
			$tempUserIds = User::where('email',$email)->pluck('id'); 
			if(count($tempUserIds) > 0){
				$tempUserIds = $tempUserIds->toArray();
				$qRaw2 = "  user_id in (" . implode(",",$tempUserIds).")";
			} 
		}elseif(@$mobile){  
			$tempUserIds = User::where('mobile',$mobile)->pluck('id'); 
			if(count($tempUserIds) > 0){
				$tempUserIds = $tempUserIds->toArray();
				$qRaw2 = "  user_id in (" . implode(",",$tempUserIds).")";
			} 
		}elseif(@$user_id){  
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
		$projects = Project::latest()->pluck("title","id");
		
		if(auth()->user()->role == 'admin'){
			
		}else{
			$conditions['user_id'] = auth()->user()->id;
		}
	
		
		$worksheets = Worksheet::
		whereRaw($qRaw1)		
		->whereRaw($qRaw2)
		->whereRaw($qRaw3)
		->where($conditions)
		->whereBetween('date', [$start_date, $end_date])->get(); 
		
		$i=0;
		
		$userNameList = User::pluck('name','id'); 
		$userEmailList = User::pluck('email','id'); 
		$output= [];
		foreach($worksheets as $k => $worksheet){
			$i++;
			$cleanedDescription = strip_tags($worksheet->description);
			$worksheet->description = $cleanedDescription;

			$output[$i][] = $i;
			$output[$i][] = @$userNameList[$worksheet->user_id] . " (" . @$userEmailList[$worksheet->user_id] . ")";
			$output[$i][] = $worksheet->date;
			$output[$i][] = $projects[$worksheet->project_id];
			$output[$i][] = $worksheet->task;
			$output[$i][] = $worksheet->description;
			$output[$i][] = ucfirst($worksheet->status);
			$output[$i][] = date(@$worksheet->created_at);
			$output[$i][] = date(@$worksheet->updated_at);
		} 
		
		return collect($output);
		
    }

    /**
     * Add headings to the export file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Sr.No.', 'Staff', 'Date', 'Project', 'Title', 'Description', 'Status','Created At', 'Updated At'
        ];
    }
}
