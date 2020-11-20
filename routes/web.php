<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $jobs = \App\Models\Job::get();
    foreach ($jobs as $job){
        dispatch((new \App\Jobs\UrlProcessingJob($job)));
    }
    return view('welcome');
});
