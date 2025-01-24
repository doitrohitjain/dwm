@extends('layouts.app')

@section('content')
<div class="container">
	<h1><span style=';'>
		<a href="{{ route('home.employee_listing') }}" class="btn btn-primary">
			Staff Listing
		</a>
	</span></h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Staff Registration') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('employee_store') }}" id ="staffRegistration">
                        @csrf 
						<input type="hidden" name='ajaxRequest' value='1' id='ajaxRequest'>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Projects') }} <span class="mandatory">*</span></label> 
                            <div class="col-md-6">   
								<select name="projects_id[]" id="projects_id" class="form-select multiselect" multiple >
									@foreach ($projects as $k => $option)
										<option value="{{ $k }}">{{ $option }}</option>
									@endforeach
								</select>
								  
								@error('projects_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
                        </div> 
						
						<div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }} <span class="mandatory">*</span></label> 
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control namecls @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						<div class="row mb-3">
                            <label for="mobile" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }} <span class="mandatory">*</span></label> 
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="numAllowOnly form-control @error('name') is-invalid @enderror" name="mobile" value="{{ old('name') }}" maxlength="10" required2 autocomplete="mobile" autofocus> 
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

 
				
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }} <span class="mandatory">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required2 autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }} <span class="mandatory">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required2 autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }} <span class="mandatory">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required2 autocomplete="new-password">
                            </div>
                        </div> 
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
    <script src="{!! asset('public/js/validation.js') !!}"></script> 
@endsection 

