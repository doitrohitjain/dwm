@extends('layouts.app')

@section('content')
<div class="container">
    <h1>
		@if(Auth::user()->role == 'admin')
		@else
			My
		@endif
			Daily Worksheets
		</h1>

		@if(Auth::user()->role == 'admin')
		@else
			<!-- Form to Add Worksheet -->
			<fieldset class="border p-4 rounded">
				<legend class="w-auto px-3 text-primary"></legend>
				<form action="{{ route('worksheets.store') }}" method="POST" class="mb-4" id="myForm">
					@csrf
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="date">Date <span class="mandatory">*</span></label>
								<input type="date" name="date" id="date" class="form-control date" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="status">Project <span class="mandatory">*</span></label>
								<select name="project_id" id="project_id" class="form-select" required>
									<option value="">Please Select</option>
									
									@foreach ($projects as $k => $option)
										<option value="{{ $k }}">{{ $option }}</option>
									@endforeach
								</select>
								  
								@error('project_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						
						<div class="col-md-5">
							<div class="form-group">
								<label for="task">Task <span class="mandatory">*</span></label>
								<input type="text" name="task" id="task" class="form-control" placeholder="Task Name" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="status">Status <span class="mandatory">*</span></label>
								 <select id="status" name="status" class="form-control" required>
								  <option value="">Please Select</option>
								  <option value="pending">Pending</option>
								  <!-- <option value="wip">Work In Progress</option> -->
								  <option value="completed">Completed</option>
								</select>
							</div>
						</div>
					</div> 
					<div class="form-group">
						<label for="description">In-depth Task Explanation <span class="mandatory"></span></label>
						<textarea name="description" id="description" class="form-control editor-class" placeholder="Task Description" ></textarea>
					</div>
					
					<br>
					<button type="submit" class="btn btn-success addmytask">Add My Task</button>
				</form>
			</fieldset>
			<br>
	@endif
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-sm">
			<thead>
				<tr>
					<th>Sr.No.</th> 
					@if(Auth::user()->role == 'admin')
						<th>Staff</th>
					@endif
					<th>Project</th>
					<th>Task</th>
					<th>Date</th>
					<th>Status</th>
					@if(Auth::user()->role == 'admin')
						<th>Actions</th>
					@endif
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
								({{ @$userEmailList[$worksheet->user_id] }})
							</td>
						@endif 
						<td>{{ @$projects[$worksheet->project_id] }}</td>
						<td>{{ $worksheet->task }}</td>
						<td>{{ date("d-m-Y",@strtotime(@$worksheet->date)) }}</td>
						<td>{{ ucfirst($worksheet->status) }}</td>
						@if(Auth::user()->role == 'admin')
							<td>
								<a href="{{ route('worksheets.show', Crypt::encrypt($worksheet->id)) }}" title="View Worksheet" class="btn2 btn-info2"><i class="btn bi-eye-fill"></i></a>
								<a href="{{ route('worksheets.edit', Crypt::encrypt($worksheet->id)) }}" title="Update Worksheet" class="btn2 btn-warning2"><i class="btn bi-pencil-fill"></i></a>
								<form action="{{ route('worksheets.destroy', Crypt::encrypt($worksheet->id)) }}" method="POST" style="display:inline-block;">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn2 btn-danger2" title="Delete Worksheet" onclick="return confirm('Are you sure?')">
										<i class="btn bi-trash-fill"></i>
									</button>
								</form>
							</td>
						@else 
						@endif
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


