<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Laravel\Passport\Console\InstallCommand::class,
        \Laravel\Passport\Console\KeysCommand::class,
        \Laravel\Passport\Console\ClientCommand::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

//        $schedule->call(function () {
//            $now = new \DateTime();
//            $datetime = $now->modify('30 day');    
//            DB::table('logging')->where('updated_at', '<', $datetime)->delete();
//        })->hourly();  //->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
