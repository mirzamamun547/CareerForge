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
Route::get('/employer/applicants', function () {
    return view('employer.applicants');
});
Route::get('/employer/applicant-details', function () {
    return view('employer.applicant-details');
});
Route::get('/employer/interview-schedule', function () {
    return view('employer.interview-schedule');
});
Route::get('/employer/schedule-interview', function () {
    return view('employer.schedule-interview');
});
Route::get('/employer/company-profile', function () {
    return view('employer.company-profile');
});
Route::get('/employer/notifications', function () {
    return view('employer.notifications');
});
