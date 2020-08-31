<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Model\Message;
use App\Model\Receiver;
use Carbon;


class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '寄出已預約的當日email';

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
        $this->sendMail();
    }

    // 這句可以讓執行完後，在畫面上顯示一些提示
    // $this->info('Update num1 finished');

    
    /**
     * Mail
     */
    protected function sendMail() 
    {
        //找出已預約今日並已到期要發送的訊息
        $msg = Message::where('send_at', '<', date('Y-m-d H:i:s'))
                        ->where('send_at', 'like', '%' . date('Y-m-d') . '%')
                        ->where(function ($query) {
                            $query->orwhere('type', '=', 1)
                                  ->orWhere('type', '=', 2);
                        })
                        ->where('id_status', 21)
                        ->get();

        foreach( $msg as $dataMsg){
            $mailTitle = $dataMsg['title'];
            $mailContents = $dataMsg['content'];

            //訊息收件人
            $emailAddr = Receiver::select('email')
                                ->where('id_message', $dataMsg['id'])
                                ->get();

            if( !empty($emailAddr) ){
                //寄送訊息
                Mail::send('frontend.model_email', ['content'=>$mailContents], function($message) use ($mailTitle, $emailAddr) {
                    $message->subject($mailTitle);
                    foreach ($emailAddr as $email) {
                        $message->to($email['email']);
                    }
                });              
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

}
