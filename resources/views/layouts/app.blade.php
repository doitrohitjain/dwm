<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
	 
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<!-- CKEditor 5 Stable CDN -->
	<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

	
    <!-- Scripts -->

    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) Local -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
	<link rel="icon" type="image/x-icon" href="{{ asset('public/images/logo.png') }}">
	<link href="{{ asset('public/css/custom.css') }}" rel="stylesheet">
	<script src="{{ asset('public/js/custom.js') }}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm headerNav">
            <div class="container">
                <a class="navbar-brand main_menu_navbar_brand" href="{{ url('/') }}">
					<img src="{{ asset('public/images/logo.png') }}" width="40" height="40" alt="Logo">
					 {{ config('app.name', 'Rohit Jain') }}
                </a>
                
				@if(auth()->user())
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
					</button>
				@endif

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto main_menu_navbar_brand">
                        <!-- Authentication Links --> 
						@guest
							@if(Route::currentRouteName() === 'login')
							@else 
								@if (Route::has('login'))
									<li class="nav-item">
										<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
									</li>
								@endif
							@endif 
                        @else
							@if (Route::has('home'))
								<li class="nav-item">
									<a class="nav-link mainitem nav-link-active" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
								</li>
							@endif
							@if (Route::has('dashboard'))
								<li class="nav-item">
									<a class="nav-link mainitem nav-link-active" href="{{ route('dashboard') }}">{{ __('Daily Worksheet') }}</a>
								</li>
							@endif
					 
							@if(auth()->user()->role == 'admin')
								@if (Route::has('employee_register'))
									<li class="nav-item">
										<a class="nav-link mainitem" href="{{ route('employee_register') }}">{{ __('Staff Registration') }}</a>
									</li>
								@endif  
							@endif 
							<li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link mainitem dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   Reports
                                </a> 
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									
									@if(Route::has('reports.index'))
										<a class="nav-link" href="{{ route('reports.index') }}">{{ __(' Worksheets Report') }}</a>
									@endif 
									@if(auth()->user()->role == 'admin')
										@if(Route::has('home.employee_listing')) 
											<a class="nav-link " href="{{ route('home.employee_listing') }}">{{ __('Staff Report') }}</a>
										@endif
										@if(Route::has('projects.index'))
											<a class="nav-link" href="{{ route('projects.index') }}">{{ __(' Project Report') }}</a>
										@endif 
									@endif
                                </div>
                            </li>
							
						 
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link mainitem dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Welcome, {{ Auth::user()->name }}
                                </a> 
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<a class="dropdown-item"href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										Role : <b>{{ ucfirst(Auth::user()->role) }}</b>
									</a> 
									<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4"> 
			@include('elements.appflashmessage')
			@yield('content') 
        </main> 
	  
		
		<footer class="bg-dark text-white py-4">
			<div class="container">
				<div class="row">
					<!-- Column 1: About -->
					<div class="col-md-6">
						<h5>About Us</h5>
						<p> 
							Welcome to our Daily Worksheet, Employee, and Report Management System! Our platform is designed to streamline your workplace operations, making task management, employee tracking, and reporting easier and more efficient. Whether you're a small business or a growing organization, we provide a user-friendly solution tailored to meet your needs.  
							<br>
							Join us today and experience the future of workplace efficiency! 
						</p>
					</div> 
				   
					<!-- Column 3: Contact -->
					<div class="col-md-4">
						<h5>Contact Us</h5>
						<p>
							<i class="bi bi-geo-alt-fill"></i> IT Building,Yojana Bhawan, Tilak Marg,  <br>
							<i class="bi bi-telephone-fill"></i> C-Scheme Jaipur-302005 (Raj), INDIA  
						</p>
					</div>
					<!-- <div class="col-md-2">
						<h5>Downloads</h5>
						<p>
							<a href="{{ url('download-apk') }}" class="btn btn-primary">
								Download Android App
							</a>
						</p>
					</div> -->
				</div>
				<hr class="bg-white">
				<div class="text-center">
					<p class="mb-0">&copy; {{ date("Y") }} Designed, Developed, and Maintained by RISL Team. All rights reserved.</p>
				</div>
			</div>
		</footer> 
		 
		@include('elements.apploader')
    </div>
	<style>
		 .mandatory {
		  color: red;
		}
		@media (max-width: 767px) {
    .navbar-brand img {
        width: 30px;
        height: 30px;
    }
} 		
	</style>  
	
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('customjs')

<script>
    const staffValidateUrl = "{{ route('staffRegisterValid') }}";
    const staffUpdateValidateUrl = "{{ route('staffUpdateRegisterValid') }}";
</script>
<script>
	$(document).on("click", ".searchBtnCls", function () {
		// Find the closest parent form
		let parentForm = $(this).closest("form");
		// Update the form's action URL
		let newUrl = "{{route('reports.index')}}"; // Replace with your desired URL
		parentForm.attr("action", newUrl);
		 
		// Submit the form
		parentForm.submit();
	}); 
	
	 
		
	$(document).on("click", ".searchWithSortingBtnCls", function () {
		// Find the closest parent form
		let parentForm = $(this).closest("form");
		// Update the form's action URL
		let newUrl = "{{route('reports.downloadExcel')}}"; // Replace with your desired URL
		parentForm.attr("action", newUrl);
		 
		// Submit the form
		parentForm.submit();
	}); 
	
</script>

<script> 
		 
    $(document).ready(function() {
        $('.multiselect').select2({
            placeholder: "Please Select",
            allowClear: true
        });
    }); 
	function showLoading() {  
		$('.mainCls').removeClass('hide');
	} 
	function hideLoading() { 
		$('.mainCls').addClass('hide');
	}

	document.onreadystatechange = function () {
		var state = document.readyState;
		
		if (state == 'interactive') {
			showLoading();
		} else if (state == 'complete') {
			hideLoading();
		}
		var height = $(window).height();
	}; 
	
	
	$(document).on("click", ".showLoadingCls", function () {
		//showLoading();
    });
	  
	$(document).bind('ajaxStart', function(){ 
		showLoading();
	}).bind('ajaxStop', function(){
		hideLoading();
	});

	
	/* $(document).on("submit", "form", function (event) {
		event.preventDefault(); // Prevent default form submission (to stop the request)

		var $submitButton = $(this).find('button[type="submit"], input[type="submit"]'); // Find the submit button
		// Check if the form has the class 'notneedsync'
		if ($(this).hasClass('notneedsync')) {
			// If the form has 'notneedsync' class, don't update the button text and don't disable it
			$submitButton.prop('disabled', false); // Ensure button is enabled
			var form = this;
			// Submit the form normally
			form.submit(); // This submits the form (default action)
			return true; // Continue normal form submission
		} else {
			// If the form does not have 'notneedsync' class, update button text and disable it
			$submitButton.prop('disabled', true); // Disable the button
			$submitButton.text('Syncing...'); // Update button text
			showLoading(); // Show loading indicator
		}

		var form = this;
		// Submit the form normally
		form.submit(); // This submits the form (default action)
	}); */


</script>

<script>
	if (document.querySelector('.editor-class')) {
		let editorInstance; 
		// Initialize CKEditor
		ClassicEditor
			.create(document.querySelector('.editor-class'))
			.then(editor => {
				editorInstance = editor;
			})
			.catch(error => {
				console.error(error);
			});
	}
</script>
@php 
  $ip = NULL;
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty(@$_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
      $ip = $_SERVER['REMOTE_ADDR'];
  } 
  

  
  function getClientIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			// IP from shared internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// IP passed from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			// IP from remote address
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	$clientIP = getClientIP();
@endphp


@php  
	//@include('elements.appga')
@endphp
	
<script>
var isStopTheFeatchers = true; 
$(document).ready(function() {  
	var clientIP = "@php echo $clientIP;  @endphp";
	
	if(clientIP == "10.68.181.236" || clientIP == "10.68.181.175"){
		isStopTheFeatchers = false;
	}   
	if(isStopTheFeatchers){
		window.onload = function(){
			window.history.forward();
		}; 
		window.onunload = function() {
			null;
		}; 
	} 
	
	$( ".txtOnly" ).keypress(function(e) {
		var key = e.keyCode;
		if (key >= 48 && key <= 57) {
			e.preventDefault();
		}
	});
	
	$(".numAllowOnly").on("keypress", function (e) {
		var key = e.which || e.keyCode; // Get the key code
		// Allow only numbers (0-9)
		if (key < 48 || key > 57) {
			e.preventDefault(); // Prevent non-numeric characters
		}
	});

 
	$(document).on("keydown", function (e) {
		
		if (isStopTheFeatchers && (
			e.key === "F12" || // Disable F12
			(e.ctrlKey && e.shiftKey && e.key === "I") || // Disable Ctrl+Shift+I
			(e.ctrlKey && e.key === "U") // Disable Ctrl+U
		)) {
			e.preventDefault();
			Swal.fire({
				icon: 'error',
				title: 'Developer Features Disabled',
				text: 'This page restricts certain actions to protect its content.',
			});
			return false;
		}
	});
	 $(document).on("contextmenu", function (e) {
		if (isStopTheFeatchers ){
			e.preventDefault();
			Swal.fire({
				icon: 'error',
				title: 'Validation Error',
				text: 'Right-click is disabled!',
			}); 
			return false;
		}
	});

	  

	// Prevent dragging
	$(document).on("dragstart", function () {
		if (isStopTheFeatchers ){
			e.preventDefault();
			Swal.fire({
				icon: 'error',
				title: 'Validation Error',
				text: 'Dragging is disabled!',
			});
		}
	});


});




    // Initialize CKEditor for the specific class
    // document.querySelectorAll('.editor-class').forEach(editorElement => {
		// ClassicEditor.create(editorElement)
		// .catch(error => console.error(error));
    // });
	window.onload = function() {
		var today = new Date().toISOString().split('T')[0];
		if (document.querySelector('.date')) {
			document.querySelector('.date').setAttribute("max", today);
			var oldval = document.querySelector('.date').getAttribute('data-oldval');
			// console.log(oldval);
			// alert(oldval);
			// alert(today);
			if(oldval && oldval != ""){
				document.querySelector(".date").setAttribute("value", oldval);
			}else{
				document.querySelector(".date").setAttribute("value", today);
			}
		}

		if (document.querySelector('.end_date')) {
			document.querySelector('.end_date').setAttribute("max", today);
			var oldval = document.querySelector('.end_date').getAttribute('data-oldval');
			
			if(oldval && oldval != ""){
				document.querySelector(".end_date").setAttribute("value", oldval);
			}else{
				document.querySelector(".end_date").setAttribute("value", today);
			}
		} 		
	};
	 
  </script>
</body>
</html>
