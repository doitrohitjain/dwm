@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Staff <span style=';'>
	
		<!--<a href="{{ route('employee_register') }}" class="btn btn-primary">
			Staff Registration
		</a>-->
	</span></h1>
	<fieldset> 
		<!-- Form to Generate Report -->
		<form action="{{ route('home.employee_listing') }}" method="POST" class="mb-4 notneedsync" id="myForm">
			@csrf
			<div class="row">
				@if(auth()->user()->role == 'admin') 
					<div class="col-md-4">
						<div class="form-group">
							<label for="user_id">Name</label> 
							
							<input type ="text" name="name" id="name" value="{{@$data['name']}}" class="form-control" >
								
						</div>
					</div> 
					<div class="col-md-4">
						<div class="form-group">
							<label for="user_id">Email</label> 
							
							<input type ="email" name="email" id="email" value= "{{@$data['email']}}" class="form-control" >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="user_id">Mobile</label> 
							<input type ="mobile" name="mobile" id="mobile" value="{{@$data['mobile']}}" class="form-control" >
						</div>
					</div>
					
				<div class="col-md-4">  
					<div class="form-group">				
						<label for="projects_id">Projects</label>
						@php 
							$projectsSelected = [];
							if(@$data['projects_id']){
								$projectsSelected = @$data['projects_id'];
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
				<div class="col-md-4">  
						<div class="form-group">				
						<label for="projects_id">Role</label>
						@php 
							$roleSelected = [];
							if(@$data['role']){
								$roleSelected = @$data['role'];
							}
						@endphp
						<select name="role[]" id="role" class="form-control form-select multiselect" multiple>
							@foreach ($roleList as $k => $option)
								<option value="{{ $k }}" {{(in_array($k,@$roleSelected)) ? 'selected' : '' }}  >{{ $option }}</option>
							@endforeach
						</select> 
						@error('projects_id')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror 
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
						<button type="submit" class="btn btn-info text-white ">Search</button>
						<!--<button type="submit" class="btn btn-warning text-white">Export Report</button>-->
						<a href="{{ route('home.employee_listing') }}" class="btn btn-primary">
							Reset
						</a>
						<span style='float:right;'>
							<a href="{{ route('employee_register') }}" class="btn btn-primary">
								Staff Registration
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
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Role</th>
                <th width="20%">Assigned Projects</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody> 
			@foreach ($users as $index => $user)
			<tr>
				<td>{{ $index + 1 + (($users->currentPage() - 1) * $users->perPage()) }}</td>	
				
                <td><b>{{ $user->name }}</b></td>
                <td>{{ $user->email }}</td>
                <td>{{ @$user->mobile }}</td>
                <td>{{ ucfirst($user->role) }}</td>
				<td>
					@if(@$user->projects_id)
						@php 
					$user->projects_id = json_decode(@$user->projects_id); 
					@endphp
					@endif
					@php 
						$tempProjects = [];
					@endphp
					 @if($user->projects_id)
						 @foreach($user->projects_id as $project)
							@php $tempProjects[] = $projects[$project] @endphp
						 @endforeach
						@php 
							echo implode(",",$tempProjects);
						@endphp
					@endif
				</td> 
                <td>  
					<div style="display: flex; align-items: center;">
					<!-- <a href="{{ route('home.show', Crypt::encrypt($user->id)) }}" class="btn btn-info">
					<i class="btn bi-eye-fill"></i>
					</a>
					<a href="{{ route('home.edit', Crypt::encrypt($user->id)) }}" class="btn btn-warning">
					<i class="btn bi-pencil-fill"></i>
					</a> -->
					 
					
					
						<a href="{{ route('home.staffedit', Crypt::encrypt($user->id)) }}" class="btn3 btn-warning2" title="Update staff" style="margin-right:8px">
							<i class="btn bi-pencil-fill"></i>
						</a>
						
						<!-- <a href="{{ route('home.change_password', Crypt::encrypt($user->id)) }}" class="btn btn-success">Change Password</a> -->
						
						<form action="{{ route('home.destroy', Crypt::encrypt($user->id)) }}" method="POST" style="margin-top: 17px;border:none;">
							@csrf
							@method('DELETE')
							<button type="submit"  title="Delete staff" class="btn text-red" onclick="return confirm('Are you sure?')" style="border:none;">
								<i class="btn bi-trash-fill"></i>
							</button>
						</form>
					</div>

					<!-- <svg class=""  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"style="color:#dc3545;">  <path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z" />  <line x1="18" y1="9" x2="12" y2="15" />  <line x1="12" y1="9" x2="18" y2="15" /></svg> -->
					
				</td>
            </tr>
            @endforeach
			<tr>
				<td colspan="10">
					{{ $users->withQueryString()->links('elements.paginater') }}
				</td>
			</tr>
			
        </tbody>
    </table>
	</div>
</div>
@endsection

 