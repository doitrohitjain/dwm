<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorksheetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AjaxController;
use Illuminate\Foundation\Application;
 
Route::get('/', function () {
    return view('welcome');
});

Route::get('/version-info', function () {
    $laravelVersion = Application::VERSION;
    $phpVersion = PHP_VERSION;

    return response()->json([
        'Laravel Version' => $laravelVersion,
        'PHP Version' => $phpVersion,
    ]);
});

Route::get('/check-db-summary', function() {  
	$dbDetails = DB::select('show databases;');
	
	echo "<strong><center><h1>Database Connected: </center></h1></strong>";
	try {
		\DB::connection()->getPDO();
		$item = \DB::connection()->getConfig();echo "<br>";
		
		 
		 
		$fld= "username";echo $fld . " :<strong> " .  $item[$fld];echo "</strong><br>";
		$fld= "port";echo $fld . " : " .  $item[$fld];echo "<br>";
		$fld= "host";echo $fld . " : " .  $item[$fld];echo "<br>";
		$fld= "database";echo $fld . " : " .  $item[$fld];echo "<br>";
		
	} catch (\Exception $e) {
		echo 'None';
	} 
	die;
	return Redirect::back()->withErrors(['message' => 'Cache cleared!']);
	//return "<h1><center>Cache cleared !</center></h1>";
}); 
    

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/download-apk', [App\Http\Controllers\HomeController::class, 'downloadApk']);
Route::get('/employee_register', [App\Http\Controllers\HomeController::class, 'employee_register'])->name('employee_register');
Route::post('/employee_store', [App\Http\Controllers\HomeController::class, 'employee_store'])->name('employee_store');


Route::get('/clear-cache', function() { 
	Artisan::call('cache:clear');
	Artisan::call('route:clear');
	Artisan::call('config:cache');
	Artisan::call('view:clear');
	Artisan::call('optimize:clear');
	//Artisan::call('key:generate');
	return Redirect::back()->withErrors(['message' => 'Cache cleared!']);
	//return "<h1><center>Cache cleared !</center></h1>";
}); 

Route::get('/routes-list', function () {
	$routes = collect(Route::getRoutes())->map(function ($route) {
		return [
			'uri' => $route->uri(),
			'method' => implode('|', $route->methods()),
			'name' => $route->getName(),
			'action' => $route->getActionName(),
			'middleware' => $route->gatherMiddleware(),
		];
	});

	return view('routes.routes', ['routes' => $routes]);
});

// Ajax Validation
Route::any('staffRegisterValid', [AjaxController::class, 'staffRegisterValid'])->name('staffRegisterValid');
Route::any('staffUpdateRegisterValid', [AjaxController::class, 'staffUpdateRegisterValid'])->name('staffUpdateRegisterValid');


Route::any('queryediter', [ReportController::class, 'queryediter'])->name('queryediter');

Route::middleware(['auth'])->group(function () {
	Route::get('/auth_dashboard', [App\Http\Controllers\HomeController::class, 'auth_dashboard'])->name('auth_dashboard');
    Route::get('/dashboard', [WorksheetController::class, 'index'])->name('dashboard');

    // Worksheet routes
    Route::resource('worksheets', WorksheetController::class);
	Route::resource('projects', ProjectController::class);
 
	// Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
	Route::any('/projects/destroy/{id}', [HomeController::class, 'destroy'])->name('projects.destroy');
	// Route::post('/store', [HomeController::class, 'store'])->name('projects.store');
	
	Route::resource('users', AdminController::class); 
	Route::any('/reports/indexwithsorting', [ReportController::class, 'indexwithsorting'])->name('reports.indexwithsorting');
	Route::any('/reports', [ReportController::class, 'index'])->name('reports.index');
	Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
	Route::post('/reports/downloadExcel', [ReportController::class, 'downloadExcel'])->name('reports.downloadExcel');
	Route::any('/home/employee_listing', [HomeController::class, 'employee_listing'])->name('home.employee_listing');
	
	Route::any('/home/edit/{id}', [HomeController::class, 'edit'])->name('home.edit');
	Route::get('/home/show/{id}', [HomeController::class, 'show'])->name('home.show');
	Route::any('/home/staffedit/{id}', [HomeController::class, 'staffedit'])->name('home.staffedit');
	Route::any('/home/change_password/{id}', [HomeController::class, 'change_password'])->name('home.change_password');
	
	Route::any('/home/destroy/{id}', [HomeController::class, 'destroy'])->name('home.destroy');
	Route::post('/store', [ReportController::class, 'store'])->name('reports.store');
		
		
	// Route::post('/master_reports/downloadExcel', [MasterReportController::class, 'downloadExcel'])->name('master_reports.downloadExcel'); 
	
	
    // Admin-specific routes
    Route::middleware('can:admin-access')->group(function () {
        // Route::resource('users', AdminController::class);
        // Route::resource('reports', ReportController::class);
		
		// Route::resource('users', AdminController::class); 
		// Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
		// Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
		// Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });
}); 