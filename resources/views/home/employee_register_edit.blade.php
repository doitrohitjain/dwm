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
                    <form method="POST" action="{{ route('home.staffedit',Crypt::encrypt($userData->id)) }}" id ="staffUpdateRegistration">
                        @csrf 
						<input type="hidden" name='ajaxRequest' value='1' id='ajaxRequest'> 
						<input type="hidden" name='id' value='{{ Crypt::encrypt($userData->id) }}' id='id'> 
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Projects') }} <span class="mandatory">*</span></label> 
                            <div class="col-md-6">   
 							@php
							if(@$userData->projects_id){
							$selected = json_decode(@$userData->projects_id); 
							}
						@endphp
								<select name="projects_id[]" id="projects_id" class="form-select multiselect" multiple required2>
									@foreach ($projects as $k => $option)
										<option value="{{ $k }}"  {{(in_array($k,$selected)) ? 'selected' : '' }}>{{ $option }}</option>
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
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ @$userData->name }}" required2 autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

 
				
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }} <span class="mandatory">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{@$userData->email}}" required2 autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						<div class="row mb-3">
                            <label for="mobile" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }} <span class="mandatory">*</span></label> 
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="numAllowOnly form-control @error('name') is-invalid @enderror" name="mobile" value="{{ @$userData->mobile }}" maxlength="10" required2 autocomplete="mobile" autofocus> 
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       <!-- <div class="row mb-3">
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
                        </div> -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
								<!-- <a href="{{ route('home.change_password', Crypt::encrypt($userData->id)) }}" class=" hide btn btn-success">Change Password
								</a>-->
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



