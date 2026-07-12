<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\JobListing;
use App\Models\Setting;
use Illuminate\Console\Command;

class CloseExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'jobs:close-expired';

    /**
     * The console command description.
     */
    protected $description = 'Automatically close job listings whose deadline has passed.';

    public function handle(): int
    {
        // Respect the admin toggle in Settings > "Auto-close expired jobs".
        if (Setting::get('auto_close_expired_jobs', '1') !== '1') {
            $this->info('Auto-close is turned off in Settings. Skipping.');
            return self::SUCCESS;
        }

        $expiredJobs = JobListing::where('status', 'Active')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->get();

        if ($expiredJobs->isEmpty()) {
            $this->info('No expired job listings found.');
            return self::SUCCESS;
        }

        foreach ($expiredJobs as $job) {
            $job->update(['status' => 'Closed']);
        }

        ActivityLog::create([
            'user_name' => 'System',
            'action' => 'Auto-closed expired job listings',
            'details' => $expiredJobs->count() . ' job(s) closed: ' . $expiredJobs->pluck('title')->implode(', '),
        ]);

        $this->info($expiredJobs->count() . ' expired job listing(s) closed.');

        return self::SUCCESS;
    }
}