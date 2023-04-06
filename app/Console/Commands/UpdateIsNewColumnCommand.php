<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateIsNewColumnJob;

class UpdateIsNewColumnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:is-new-column';

    protected $description = 'Update the is_new column for users created within the last 5 minutes.';

    /**
     * The console command description.
     *
     * @var string
     */
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new UpdateIsNewColumnJob);
    }
}