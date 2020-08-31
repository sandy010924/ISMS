<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Message;
use App\Model\Receiver;
use Carbon;


class ScheduleSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '將預約簡訊更改狀態為已傳送';

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
        $this->ScheduleSMS();
    }

    // 這句可以讓執行完後，在畫面上顯示一些提示
    // $this->info('Update num1 finished');

    
    /**
     * Mail
     */
    protected function ScheduleSMS() 
    {
        //找出已預約到時間要發送的訊息
        $msg = Message::where('send_at', '<', date('Y-m-d H:i:s'))
                        ->where(function ($query) {
                            $query->orwhere('type', '=', 0);
                                //   ->orWhere('type', '=', 1);
                        })
                        ->where('id_status', 21)
                        ->get();

        foreach( $msg as $dataMsg){              
            // 更新訊息狀態為已傳送
            Message::where('id', $dataMsg['id'])
                    ->update([
                        'id_status' => 19
                    ]);  

            
            // 更新收件狀態為已傳送
            Receiver::where('id_message', $dataMsg['id'])
                    ->update([
                        'id_status' => 19
                    ]);  
        }
    }

}
