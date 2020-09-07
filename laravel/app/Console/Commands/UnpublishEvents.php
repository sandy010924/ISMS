<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\EventsCourse;


class UnpublishEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unpublish:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '過期場次下架';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->unpublish();
    }

    // 這句可以讓執行完後，在畫面上顯示一些提示
    // $this->info('Update num1 finished');

    
    /**
     * 取消場次
     */
    protected function unpublish() 
    {
        //找出過期場次取消場次
        $msg = EventsCourse::where('course_start_at', '<', date('Y-m-d H:i:s'))
                        ->where('unpublish', 0)
                        ->update(['unpublish' => 1]);

    }

}
