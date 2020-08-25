<?php

namespace App\Console;

use App\Console\Commands\UpdateUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendEmails;
use App\Console\Commands\SetStamp;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmails::class,
        UpdateUsers::class,
        SetStamp::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * add to cron
         */
        //  */5 * * * * php /var/www/html/pis/artisan schedule:run >> /dev/null 2>&1
        $schedule->command('emails:send')->everyFiveMinutes();
        $schedule->command('users:update')->daily(); //Run the task every day at midnight
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
