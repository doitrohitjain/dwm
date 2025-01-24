@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(auth()->user()) 
				<h1>Welcome, {{ Auth::user()->name }}</h1> 
			@endif 
			<div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif 
					<div class="container my-4">
						<div class="row text-center">
							<!-- Counter Card 1 -->
							<div class="col-md-4 mb-4">
								<div class="card shadow-sm" style="border-left: 5px solid #007bff;">
									<div class="card-body">
										<h3 class="card-title">Tasks</h3>
										<h2 class="display-4">{{ @$counter['worksheets'] }}</h2>
										<p class="card-text text-muted">Total tasks entered by staff in projects</p>
										<a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">View Details</a>
									</div>
								</div>
							</div>
							@if(auth()->user()->role == 'admin')
								<!-- Counter Card 2 -->
								<div class="col-md-4 mb-4">
									<div class="card shadow-sm" style="border-left: 5px solid #28a745;">
										<div class="card-body">
											<h3 class="card-title">Staff</h3>
											<h2 class="display-4">{{ @$counter['users'] }}</h2>
											<p class="card-text text-muted">Total registered staff members</p>
											<a href="{{ route('home.employee_listing') }}" class="btn btn-success btn-sm">View Details</a>
										</div>
									</div>
								</div> 
								<!-- Counter Card 3 -->
								<div class="col-md-4 mb-4">
									<div class="card shadow-sm" style="border-left: 5px solid #ffc107;">
										<div class="card-body">
											<h3 class="card-title">Projects</h3>
											<h2 class="display-4">{{ @$counter['projects'] }}</h2>
											<p class="card-text text-muted">Total registered projects</p>
											<a href="{{ route('projects.index') }}" class="btn btn-warning btn-sm text-white">View Details</a>
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
