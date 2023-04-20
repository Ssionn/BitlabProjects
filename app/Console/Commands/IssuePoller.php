<?php

namespace App\Console\Commands;

use App\Events\NewIssueEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class IssuePoller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:issues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Polls the Bitlab API for new issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api_token = config('services.bitlab.api_token');

        $url = 'https://bitlab.bit-academy.nl/api/v4/events?per_page=250&access_token=' . $api_token;

        $latestIssueEventId = null;

        Cache::put("latest_issue_event_id:$api_token", 0, 60 * 1); // Set the cache key to 0

        while (true) {
            $events = Http::get($url)->collect();

            // Get the latest issue event from the events
            $latestIssueEvent = $events->where('target_type', 'issue')->first();

            // If there is no latest issue event or it's the same as the previous one, wait and try again
            if (!$latestIssueEvent || $latestIssueEvent['id'] === $latestIssueEventId) {
                $this->line('No new issues found. Waiting for 60 seconds...');
                sleep(60); // Wait for 60 seconds
                Cache::flush(); // Clear the cache
                continue;
            }

            // Update the latest issue event ID and fire the event
            $latestIssueEventId = $latestIssueEvent['id'];
            event(new NewIssueEvent($latestIssueEvent));

            $this->line('New issue found! ID: ' . $latestIssueEventId);
        }
    }
}
