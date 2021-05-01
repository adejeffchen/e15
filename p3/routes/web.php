<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReleaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes that require authentication
Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects/create', [ProjectController::class, 'create']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/releases/create', [ReleaseController::class, 'create']);
    Route::post('/releases', [ReleaseController::class, 'store']);
});

Route::get('/', [PageController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::get('/releases/{id}', [ReleaseController::class, 'show']);



Route::get('/debug', function () {
    $debug = [
        'Environment' => App::environment(),
    ];

    /*
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    */
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});