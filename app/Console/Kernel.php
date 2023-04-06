<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\UpdateIsNewColumnJob;



class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

     protected $commands = [
        Commands\IndentCodeCommand::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new UpdateIsNewColumnJob)->dailyAt('1:15');
    }
    
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        

        require base_path('routes/console.php');
    }
  
}