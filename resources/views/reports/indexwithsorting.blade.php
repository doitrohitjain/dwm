@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reports  @php print_r($sortBy); @endphp
			 </h1>
	<form action="{{ route('reports.indexwithsorting') }}" method="POST" class="mb-4 notneedsync" id="myForm">
		@csrf
		<fieldset> 
			<!-- Form to Generate Report -->
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
							<button type="submit" class="btn btn-info text-white">Search</button>
							<button type="button" class="btn btn-warning text-white searchWithSortingBtnCls">Export Report</button>
							<a href="{{ route('reports.indexwithsorting') }}" class="btn btn-primary">
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
			 
		</fieldset>
		<br><br>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover table-sm">
				<thead>
					<tr>
						<th>Sr.No.</th> 
						@if(Auth::user()->role == 'admin')
							<th> 
									<input type="hidden" name="sort_by" value="user_id">
									<input type="hidden" name="direction" value="{{ ($sortBy == 'user_id' && $direction == 'asc') ? 'desc' : 'asc' }}">
									<button type="submit" class="searchWithSortingBtnClsCss btn">
										Staff
										<i class="btn {{ ($sortBy == 'user_id' && $direction == 'asc') ? 'bi-sort-down' : ($sortBy == 'user_id' && $direction == 'desc' ? 'bi-sort-up' : 'bi-sort') }}"></i>
									</button>
								
							</th>
							<th>  
								<input type="hidden" name="sort_by" value="user_email">
								<input type="hidden" name="direction" value="{{ ($sortBy == 'user_email' && $direction == 'asc') ? 'desc' : 'asc' }}">
								<button type="submit" class="searchWithSortingBtnClsCss btn">
									Email
									<i class="btn {{ ($sortBy == 'user_email' && $direction == 'asc') ? 'bi-sort-down' : ($sortBy == 'user_email' && $direction == 'desc' ? 'bi-sort-up' : 'bi-sort') }}"></i>
								</button> 
							</th>
						@endif
						<th> 
							<input type="hidden" name="sort_by" value="project_id">
							<input type="hidden" name="direction" value="{{ ($sortBy == 'project_id' && $direction == 'asc') ? 'desc' : 'asc' }}">
							<button type="submit" class="searchWithSortingBtnClsCss btn">
								Project
								<i class="btn {{ ($sortBy == 'project_id' && $direction == 'asc') ? 'bi-sort-down' : ($sortBy == 'project_id' && $direction == 'desc' ? 'bi-sort-up' : 'bi-sort') }}"></i>
							</button> 
						</th>
						<th> 
							<input type="hidden" name="sort_by" value="task">
							<input type="hidden" name="direction" value="{{ ($sortBy == 'task' && $direction == 'asc') ? 'desc' : 'asc' }}">
							<button type="submit" class="searchWithSortingBtnClsCss btn">
								Task
								<i class="btn {{ ($sortBy == 'task' && $direction == 'asc') ? 'bi-sort-down' : ($sortBy == 'task' && $direction == 'desc' ? 'bi-sort-up' : 'bi-sort') }}"></i>
							</button> 
						</th>
						<th>  
							<input type="hidden" name="sort_by" value="date">
							<input type="hidden" name="direction" value="{{ ($sortBy == 'date' && $direction == 'asc') ? 'desc' : 'asc' }}">
							<button type="submit" class="searchWithSortingBtnClsCss btn">
								Date
								<i class="btn {{ ($sortBy == 'date' && $direction == 'asc') ? 'bi-sort-down' : ($sortBy == 'date' && $direction == 'desc' ? 'bi-sort-up' : 'bi-sort') }}"></i>
							</button> 
						</th>
						<th>
							<input type="hidden" name="sort_by" value="status">
							<input type="hidden" name="direction" value="{{ ($sortBy == 'status' && $direction == 'asc') ? 'desc' : 'asc' }}">
							<button type="submit" class="searchWithSortingBtnClsCss btn">
								Status
								<i class="btn {{ ($sortBy == 'status' && $direction == 'asc') ? 'bi-sort-down' : ($sortBy == 'status' && $direction == 'desc' ? 'bi-sort-up' : 'bi-sort') }}"></i>
							</button> 
						</th>
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
							<td>{{ @$worksheet->task }}</td>
							<td>{{ $worksheet->date }}</td>
							<td>{{ ucfirst($worksheet->status) }}</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="10">
								{{ $worksheets->withQueryString()->appends(request()->query())->links('elements.paginater') }}
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
	
	</form>
</div>

@endsection
