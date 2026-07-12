<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Runs every day at midnight: closes any 'Active' job listing whose
// deadline has passed, unless the admin has turned this off in Settings.
Schedule::command('jobs:close-expired')->daily();