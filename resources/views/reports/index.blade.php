@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reports</h1>
	<fieldset> 
		<!-- Form to Generate Report -->
		@if(@$inputs)
			@php print_r(@$inputs['user_id']); @endphp
		@endif
		<form action="{{ route('reports.downloadExcel') }}" method="POST" class="mb-4 notneedsync" id="myForm">
			@csrf
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="start_date">Start Date <span class="mandatory">*</span></label>
						<input type="date" value="{{ @$inputs['start_date']}}" data-oldval="{{ @$inputs['start_date']}}" name="start_date" id="start_date" class="form-control date" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="end_date">End Date <span class="mandatory">*</span></label>
						<input type="date" value="{{ @$inputs['end_date']}}" data-oldval="{{ @$inputs['end_date']}}"  name="end_date" id="end_date" class="form-control end_date" required>
					</div>
				</div> 
				
				<div class="col-md-6">  
					<div class="form-group">				
						<label for="projects_id">Projects</label>
						@php 
							$projectsSelected = [];
							if(@$inputs['projects_id']){
								$projectsSelected = @$inputs['projects_id'];
							}
						@endphp
						<select name="projects_id[]" id="projects_id" class="form-control form-select multiselect" multiple >
							@foreach ($projects as $k => $option)
								<option value="{{ $k }}" {{(in_array($k,@$projectsSelected)) ? 'selected' : '' }}  >{{ $option }}</option>
							@endforeach
						</select> 
						@error('projects_id')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror 
					</div>
				</div> 
				
				@if(auth()->user()->role == 'admin') 
					<div class="col-md-6">
						<div class="form-group">
							<label for="user_id">Staff</label> 
							@php 
								$userSelected = [];
								if(@$inputs['user_id']){
									$userSelected = @$inputs['user_id'];
								}
							@endphp
							<select name="user_id[]" id="user_id" class="form-control form-select multiselect" multiple >
								@foreach ($userNameWithMobileList as $k => $option)
									<option value="{{ $k }}" {{(in_array($k,@$userSelected)) ? 'selected' : '' }}  >{{ $option }}</option>
								@endforeach
							</select>
						</div>
					</div> 
					
					<!-- <div class="col-md-3">
						<div class="form-group">
							<label for="email">Staff Mobile</label>
							<input type="text" name="mobile" id="mobile" class="form-control mobile numAllowOnly" maxlength="10">
						</div>
					</div>
					
					
					 <div class="col-md-3">
						<div class="form-group">
							<label for="email">Staff Name</label>
							<input type="text" name="name" id="name" class="form-control name">
						</div>
					</div>
					
					
					<div class="col-md-3">
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" name="email" id="email" class="form-control email">
						</div>
					</div> -->
					<br>
					<br>
					<br>
					
				@endif 
				
				<div class="col-md-12">
					<div class="form-group">
						<br> 
						<button type="button" class="btn btn-info text-white searchBtnCls">Search</button>
						<button type="submit" class="btn btn-warning text-white">Export Report</button>
						<a href="{{ route('reports.index') }}" class="btn btn-primary">
							Reset
						</a>
						<span style='float:right;'>
							<a href="{{ route('dashboard') }}" class="btn btn-success">
								Add My Task
							</a>
						</span>
					</div>
				</div> 
			</div>
		</form>   
	</fieldset>
	
	<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th>Sr.No.</th> 
				@if(Auth::user()->role == 'admin')
					<th>Staff</th>
					<th>Email</th>
				@endif
                <th>Project</th>
                <th>Task</th>
                <th>Date</th>
                <th>Status</th>
                <!-- <th>Actions</th> -->
            </tr>
        </thead>
        <tbody>
			@if(@$worksheets && count($worksheets) > 0)
				@foreach ($worksheets as $index => $worksheet)
				<tr>
					<td>{{ $index + 1 + (($worksheets->currentPage() - 1) * $worksheets->perPage()) }}</td>
					@if(Auth::user()->role == 'admin')
						<td>
							{{ @$userNameList[$worksheet->user_id] }} 
							@if(@$userMobileList[$worksheet->user_id])
								({{ @$userMobileList[$worksheet->user_id] }})
							@endif
						</td>
						<td>
							{{ @$userEmailList[$worksheet->user_id] }}
						</td>
					@endif 
					<td>{{ @$projects[$worksheet->project_id] }}</td>
					<td>
						<div title="Description:  @php echo strip_tags(@$worksheet->description); @endphp ">{{ @$worksheet->task }}
						</div>
					</td>
					<td>{{ date("d-m-Y",@strtotime(@$worksheet->date)) }}</td>
					<td>{{ ucfirst(@$worksheet->status) }}</td>
					<!--  @if(Auth::user()->role == 'admin')
						<td>
							<a href="{{ route('worksheets.show', Crypt::encrypt($worksheet->id)) }}" class="btn2 btn-info2"><i class="btn bi-eye-fill"></i></a>
							<a href="{{ route('worksheets.edit', Crypt::encrypt($worksheet->id)) }}" class="btn2 btn-warning2"><i class="btn bi-pencil-fill"></i></a>
							<form action="{{ route('worksheets.destroy', Crypt::encrypt($worksheet->id)) }}" method="POST" style="display:inline-block;">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn2 btn-danger2" onclick="return confirm('Are you sure?')">
									<i class="btn bi-trash-fill"></i>
								</button>
							</form>
						</td>
					@else
						<td>
						-
						</td>
					@endif -->
				</tr>
				
				@endforeach
				<tr>
					<td colspan="10">
						{{ $worksheets->withQueryString()->links('elements.paginater') }}
					</td>
				</tr>
			@else
				<tr>
					<td colspan="10">
						<center>No Task Found</center>
					</td>
				</tr>
			@endif
        </tbody> 
    </table>
	</div>
</div>

@endsection
