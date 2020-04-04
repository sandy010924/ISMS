<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentGroupdetail;
use App\Model\StudentGroup;
use Mail;

class MessageController extends Controller
{
    /**
     * 顯示細分組資料
     */
    public function showDetailGroup(Request $request)
    {
        $groupData = StudentGroup::get();

        $array_group = array();

        foreach ($groupData as $key => $value) {
            $groupData_detail = StudentGroup::leftjoin('student_groupdetail as b', 'student_group.id', '=', 'b.id_group')
                            ->leftjoin('student as c', 'c.id', '=', 'b.id_student')
                            ->select('c.id', 'c.name', 'c.email', 'c.phone')
                            ->where('b.id_group', $value['id'])
                            ->get();
            array_push($array_group, array(
                'groupName' => $value['name'],
                'groupData' => $groupData_detail
            ));
        }
        $result = $array_group;
        return $result;

    }

    /**
     * 單筆發送
     */
    public function messageApi(Request $request)
    {
        $msgContents = $request['messageContents'];
        $sendContents = str_replace("\n", chr(6), $msgContents);
        $phoneNum = $request['phoneNumber'];
        $url = 'http://smsb2c.mitake.com.tw/b2c/mtk/SmSend?';
        $url .= '&username=0908916687';
        $url .= '&password=wjx2020';
        $url .= '&dstaddr='.$phoneNum;
        $url .= '&smbody='.urlencode($sendContents);
        $url .= '&CharsetURL=UTF-8';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 多筆發送
     */
    public function messageBulkApi(Request $request) {
        $msgContents = $request['messageContents'];
        $sendContents = str_replace("\n", chr(6), $msgContents);
        $msgLen = $request['msgLen'];
        $curl = curl_init();
        $data = '';

        for ($i=0; $i < $msgLen ; $i++) {
            $data .= rand(1, 1000000).'$$'.$request['phoneNumber'][$i].'$$$$$$$$$$'.$sendContents."\r\n";
        }

        curl_setopt($curl, CURLOPT_URL, 'http://smsb2c.mitake.com.tw/b2c/mtk/SmBulkSend?username=0908916687&password=wjx2020&Encoding_PostIn=UTF-8');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HEADER,0);
        curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * Mail
     */
    public function sendMail(Request $request) {
        //從表單取得資料
        $from = [
            // 'email'=>$input['email'],
            // 'name'=>$input['name'],
            // 'subject'=>$input['subject'],
            'mailTitle' => $request['emailTitle'],
            'mailAddr' => $request['emailAddr'],
            'mailAddrLen' => $request['emailAddrLen'],
            'mailContents' => $request['emailContent']
        ];


        /*
        TODO:
            1. 細分組那邊選擇MAIL，要把名字帶過來後端
            2. email要帶入名字、在前端打的內容帶到模板上
        */

        // //填寫收信人信箱
        // $to = ['email'=>'xxx@xxx.com',
        // 'name'=>'xxx'];

        // //信件的內容(即表單填寫的資料)
        // $data = ['company'=>$input['company'],
        // 'address'=>$input['address'],
        // 'email'=>$input['email'],
        // 'subject'=>$input['subject'],
        // 'msg'=>$input['message']
        // ];

        // //寄出信件
        $name = '123';

        Mail::send('frontend.testMail', ['name'=>$name], function($message) use ($from) {
            $message->subject($from['mailTitle']);
            foreach ($from['mailAddr'] as $email) {
                $message->to($email);
            }
            // $message->from($from['email'], $from['name']);
            // $message->to($from['mailAddr'][$i]));
        });


        // $name = '123';
        // $mailTitle = $request['emailTitle'];
        // $mailAddr = $request['emailAddr'];
        // $mailAddrLen= $request['emailAddrLen'];
        // $mailContents= $request['emailContent'];
        // echo $mailTitle;
        // echo $request['emailAddr'][0];
        // echo $mailAddrLen;
        // echo $mailContents;
        // $a = "okokis101@gmail.com";

        // for ($i=0; $i < $mailAddrLen; $i++) {
        //     $result = Mail::send('frontend.testMail',['name'=>$name], function ($message,$a) {
        //         echo $a;
        //         // $message->to($a);
        //         // $message->subject($mailTitle);
        //     });
        // }
        // $result = Mail::send('frontend.testMail',['name'=>$name], function ($message) {
        //     // $message->from('CT0013315@mpg668.com','IsmsTest');
        //     $message->to('okokis101@gmail.com');
        //     $message->subject('Contact form submitted on domainname.com ');
        // });

        // return $result;

        // Mail::raw('測試使用 Laravel 5 的 Gmail 寄信服務', function($message)
        // {
        //     $message->to('okokis101@gmail.com');
        // });
    }
}
