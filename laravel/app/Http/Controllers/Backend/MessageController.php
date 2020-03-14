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
        $msgContents = $request['messageContents'];
        $sendContents = str_replace("\n","\r\n",$msgContents);
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
        echo $output;
    }
}
