<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Model\Message;
use App\Model\Receiver;
use Carbon;
use App\Model\SalesRegistration;
use App\Model\Student;
use App\Model\Course;
use App\Model\EventsCourse;


class RemindMsg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:msg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '提醒報到信件';

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
        $this->remind_week();
        $this->remind_threedays();
        $this->remind_day();
    }

    // 這句可以讓執行完後，在畫面上顯示一些提示
    // $this->info('Update num1 finished');

    
    /**
     * 前一週提醒
     */
    public function remind_week() 
    {
        $date = date("Y-m-d",strtotime("+1 week"));

        $msg = EventsCourse::leftjoin('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                            ->where('events_course.course_start_at', 'like', '%'. $date .'%')
                            ->get();
                            

        foreach( $msg as $dataMsg){
            $course = "";
            $id_course = null;
            $id_teacher = null;


            if( $dataMsg['id_course'] != -99 && $dataMsg['id_course'] != '' && $dataMsg['id_course'] != null){
                //有選擇課程

                $id_course = $dataMsg['id_course'];
                $id_teacher = Course::where('id', $dataMsg['id_course'])
                                ->first()->id_teacher;
                
                $course = Course::where('id', $dataMsg['id_course'])
                                ->first()->name;
                
                $content =  "提醒您一週後";

            }else{

                
                $content =  "提醒您一週後";
                            
            }

            
            $student = Student::where('id', $dataMsg['id_student'])->first();

            if( !empty($student) ){
                        
                //   contentStr : content,
                //   content : content.replace("\n", "<br>"),

                $send_at = date('YmdHis');
                $send_at_DB = date('Y-m-d H:i:s');
                $type = 0;
                $mailTitle = "";
                $msg_name = "自動訊息-倒數一週提醒" . $course . "場次";

                //sms
                if( $student->phone != '' || $student->phone != null){
                    $phoneNum = $student->phone;
                    //單筆簡訊
                    // $sms = $this->messageApi($phoneNum, $content, $send_at);   

                    $sendContents = str_replace("<br>", chr(6), $content);

                    $url = 'http://smsb2c.mitake.com.tw/b2c/mtk/SmSend?';
                    $url .= '&username=0908916687';
                    $url .= '&password=wjx2020';
                    $url .= '&dstaddr='.$phoneNum;
                    $url .= '&dlvtime='.$send_at;
                    $url .= '&smbody='.urlencode(strip_tags($sendContents));
                    // $url .= '&response='.route('');
                    $url .= '&CharsetURL=UTF-8';
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($curl);
                    curl_close($curl);

                    
                    /* 切割簡訊Response */
                    $output = preg_split("/[\s,]+/", $output);
                    $array_output = [];

                    /* 得到Response陣列 */
                    foreach( $output as $data){
                        $title = strstr($data, '=', true);
                        if( strpos($data, '=') != false){
                            $array_output += [
                                $title => substr($data, strlen($title)+1 )
                            ];
                        }
                    }

                    $msgid = '';
                    //寄發簡訊成功
                    if( !empty($array_output['msgid']) ){
                        $msgid = $array_output['msgid'];
                        $statuscode = $array_output['statuscode'];
                        
                        //驗證是否成功送達/預約簡訊
                        $id_status = '';
                        switch ($statuscode) {
                            case '0':
                                //預約傳送中
                                $id_status = 21;
                                break;
                            case '1':
                                //已送達業者
                                $id_status = 19;
                                break;
                            case '2':
                                //已送達業者
                                $id_status = 19;
                                break;
                            case '4':
                                //已送達手機
                                $id_status = 19;
                                break;
                            case "v":
                                //無效的手機號碼
                                $id_status = 20;
                                break;
                            default:
                                //傳送失敗
                                $id_status = 20;
                                break;
                        }


                        if($id_status == '19'){
                            $sms['status']='success';
                        }else{
                            $sms['status']='error';
                        }
                        
                    }else{
                        $sms['status']='error';
                    }



                }

                //email
                if( $student->email != '' || $student->email != null){
                    $mailTitle = "倒數一週提醒";
                    $mailAddr = $student->email;
                    // $email = $this->sendMail($mailAddr, $mailTitle, $content);

                    
                    $mailContents = str_replace("\n", "<br>", $content);
                    
                    Mail::send('frontend.model_email', ['content'=>$mailContents], function($message) use ($mailTitle, $mailAddr) {
                        $message->subject($mailTitle);
                        $message->to($mailAddr);
                    });

                    $email['status']='success';


                    $type = 2;
                }else{
                    $email['status'] = "";
                }
                
                    
                if( $sms['status'] != "error" && $email['status'] != "error"){
                    //訊息儲存進資料庫
                    $num = mb_strlen( strip_tags($content, "utf-8") );
                    $sms_num = ceil($num/70);

                    /* 新增訊息資料 */
                    $message = new Message;

                    // $message->id_student_group   = null;        // 細分組ID
                    $message->type               = $type;                 // 類型
                    $message->title              = $mailTitle;            // email標題
                    $message->content            = $content;              // 內容               
                    $message->send_at            = $send_at_DB;              // 寄送日期         
                    $message->name               = $msg_name;                 // 訊息名稱          
                    $message->id_teacher         = $id_teacher;           // 講師ID        
                    $message->id_course          = $id_course;            // 課程ID    
                    $message->id_status          = 19;            // 發送狀態      
                    $message->sms_num            = $sms_num;                  // 簡訊封數   
                
                    $message->save();
                    $id_message = $message->id;
                
                    if( $id_message != ""){
                        //收件人儲存進資料庫
                        
                        if( $type == 0){
                            //只有簡訊
                            /* 新增寄件資料 */
                            $receiver = new Receiver;

                            $receiver->id_message       = $id_message;     // 訊息ID
                            $receiver->id_student       = $dataMsg['id_student'];     // 學員ID               
                            $receiver->phone            = $phoneNum;       // 聯絡電話         
                            $receiver->email            = '';            // email         
                            $receiver->id_status        = 19;            // 發送狀態   
                            $receiver->memo             = '';                    // 備註
                            $receiver->msgid            = '';                // 簡訊序號       
                        
                            $receiver->save();

                        }else{
                            //簡訊&信箱
                            /* 新增寄件資料 */
                            $receiver = new Receiver;

                            $receiver->id_message       = $id_message;     // 訊息ID
                            $receiver->id_student       = $dataMsg['id_student'];     // 學員ID               
                            $receiver->phone            = $phoneNum;       // 聯絡電話         
                            $receiver->email            = $mailAddr;            // email         
                            $receiver->id_status        = 19;            // 發送狀態   
                            $receiver->memo             = '';                    // 備註
                            $receiver->msgid            = '';                // 簡訊序號       
                        
                            $receiver->save();
                        }
                        $id_receiver = $receiver->id;

                        if($id_receiver != "" ){
                            return 'success';
                        }
                    }
                }
            }
        }
    }

}
