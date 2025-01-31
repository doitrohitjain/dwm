@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>
			Projects <a href="{{ route('projects.create') }}" class='btn btn-primary'>Create New Project</a>
		</h1> 
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover table-sm">
			<thead>
				<tr>
					<th>Sr.No.</th> 
					<th>Title</th>
					<th>Description</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(@$projects && count($projects) > 0)
					@foreach ($projects  as $index =>  $project)
					<tr>
						<td>{{ $index + 1 + (($projects->currentPage() - 1) * $projects->perPage()) }}</td>
						<td>{{ $project->title }}</td>
						<td>@php echo @$project->description @endphp</td>
						<td>{{ ucfirst(@$masterActive[@$project->status]) }}</td>
						<td>
							<!--<a href="{{ route('projects.show', Crypt::encrypt($project->id)) }}" class="btn2 btn-info2" title="View Project"><i class="btn bi-eye-fill"></i></a>-->
							<a href="{{ route('projects.edit', Crypt::encrypt($project->id)) }}" class="btn2 btn-warning2" title="Update Project"><i class="btn bi-pencil-fill"></i></a>
							<form action="{{ route('projects.destroy', Crypt::encrypt($project->id)) }}" method="POST" style="display:inline-block;">
								@csrf
								@method('DELETE')
								<button type="submit" title="Delete Project" class="btn text-red" onclick="return confirm('Are you sure?')">
									<i class="btn bi-trash-fill"></i>
								</button>
							</form>
						</td>
					</tr> 
					@endforeach
					<tr>
						<td colspan="10">
							{{ $projects->withQueryString()->links('elements.paginater') }}
						</td>
					</tr>
				@else
					<tr>
						<td colspan="10">
							<center>No Project Found</center>
						</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>	
	</div>
@endsection


