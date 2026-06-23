<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/employer/jobs', function () {
    return view('employer.jobs');
});
Route::get('/employer/manage-jobs', function () {
    return view('employer.manage-jobs');
});
Route::get('/employer/dashboard', function () {
    return view('employer.dashboard');
});
