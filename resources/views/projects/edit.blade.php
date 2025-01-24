@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>
			Update Project <a href="{{ route('projects.index') }}" class='btn btn-primary'>Projects</a>
		</h1>
		<fieldset class="border p-4 rounded">

			<form action="{{ route('projects.update', $project) }}" method="POST" class="mb-4" id="myForm">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-7">
						<div class="form-group">
							<label for="task">Title <span class="mandatory">*</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ $project->title }}" placeholder="Title" required>
						</div>
					</div>
                    <span></span>
				</div>

				<div class="form-group">
					<label for="description">In-depth Explanation <span class="mandatory"></span></label>
					<textarea name="description" id="description" class="form-control editor-class" placeholder="Task Description" >{{ @$project->description }}</textarea>
				</div>
				<br>
				<button type="submit" class="btn btn-success addmytask">Update Project</button>
			</form>
		</fieldset>
	</div>
@endsection
