<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// use Config;
// use Mail;
// use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Backup::class,
        \App\Console\Commands\SendEmail::class,
        \App\Console\Commands\ScheduleSMS::class,
        // \App\Console\Commands\AutoMsg::class,
        \App\Console\Commands\UnpublishEvents::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 每分鐘執行 Artisan 命令 isms:backup
        // $schedule->command('isms:backup')->everyMinute()->withoutOverlapping();
        // 每天晚上11點執行 Artisan 命令 isms:backup
        $schedule->command('isms:backup')->dailyAt('6:00')->withoutOverlapping();


        // 每分鐘執行 Artisan 命令 emails:send
        $schedule->command('emails:send')->everyMinute()->withoutOverlapping();
        // $schedule->command('emails:send')->dailyAt('8:00')->withoutOverlapping();


        // 每週一早上8點 Artisan 命令 auto:msg
        // $schedule->command('auto:msg')->weekly()->wednesdays()->at('7:10');

        
        // 每分鐘執行 Artisan 命令 sms:schedule
        $schedule->command('sms:schedule')->everyMinute()->withoutOverlapping();
        // $schedule->command('emails:send')->dailyAt('8:00')->withoutOverlapping();

        
        // 每天早上6點 Artisan 命令 unpublish:events
        $schedule->command('unpublish:events')->dailyAt('6:00')->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
