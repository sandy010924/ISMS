<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\Course;

class MessageController extends Controller
{
    // joanna測試api
    public function messageApi(Request $request)
    {
        /**
         * 多筆發送
         */
        $msgContents = $request['messageContents'];
        $sendContents = str_replace("\n","\r\n",$msgContents);
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


        /**
         * 單筆發送
         */
        // $msgContents = $request['messageContents'];
        // $sendContents = str_replace("\n","\r\n",$msgContents);
        // $phoneNum = $request['phoneNumber'];
        // $url = 'http://smsb2c.mitake.com.tw/b2c/mtk/SmSend?';
        // $url .= '&username=0908916687';
        // $url .= '&password=wjx2020';
        // $url .= '&dstaddr='.$phoneNum;
        // $url .= '&smbody='.urlencode($sendContents);
        // $url .= '&CharsetURL=UTF-8';
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $output = curl_exec($curl);
        // curl_close($curl);
        // echo $output;
    }
}
