<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;

class SendDataToAlgolia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'algolia:send-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send data to Algolia';

    // public function __construct()
    // {
    //     parent::__construct();
    // }
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Project::chunk(100, function ($projects) {
            $projects->searchable();
        });

        $this->info('Data has been sent to Algolia successfully.');
    }

}
