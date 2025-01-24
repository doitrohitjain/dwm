@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>
			Add Project <a href="{{ route('projects.index') }}" class='btn btn-primary'>Projects</a>
		</h1> 
		
		<fieldset class="border p-4 rounded">
			
			<form action="{{ route('projects.store') }}" method="POST" class="mb-4" id="myForm">
				@csrf
				
				<div class="row"> 
					<div class="col-md-7">
						<div class="form-group">
							<label for="task">Title <span class="mandatory">*</span></label>
							<input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="description">In-depth Explanation <span class="mandatory"></span></label>
					<textarea name="description" id="description" class="form-control editor-class" placeholder="Task Description" ></textarea>
				</div>
				
				<br>
				<button type="submit" class="btn btn-success addmytask">Add Project</button>
			</form>
		</fieldset>
</div>

@endsection

 
 
 