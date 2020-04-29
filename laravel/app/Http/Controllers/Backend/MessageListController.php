<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Receiver;

class MessageListController extends Controller
{
    /**
     * 取消預約訊息
     */
    public function cancel(Request $request)
    {
        $id = $request->get('id_message');
        $msgid = [];
        
        $receiver = Receiver::select('msgid')->where('id_message', $id)->get('msgid');

        foreach($receiver as $data){
            array_push($msgid, $data['msgid']);
        }

        $msgid = implode(',', $msgid);

        if( $msgid != "" ){
            $url = 'http://smsb2c.mitake.com.tw/b2c/mtk/SmCancel?';
            $url .= '&username=0908916687';
            $url .= '&password=wjx2020';
            $url .= '&msgid='. $msgid;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($curl);
            curl_close($curl);

            
            // $output = '0018421490=9'. "\r\n";
            // $output .= '0018421491=0'. "\r\n". "\r\n";

            /* 切割簡訊Response */
            $output = preg_split("/[\s,]+/", $output);
            $array_output = [];
            
            /* 得到Response陣列 */
            foreach( $output as $data ){
                $title = strstr($data, '=', true);
                if( strpos($data, '=') != false){
                    $array_output += [
                        $title => substr($data, strlen($title)+1 )
                    ];
                }
            }

            /* 檢查簡訊取消成功與失敗 */
            $success = [];
            $warn = '';
            $error = [];
            foreach( $array_output as $key => $data){
                switch ($data) {
                    case '9':
                        array_push($success, $key);
                        break;
                    case '0':
                        $error[count($error)] = [
                            'msgid' => $key,
                            // 'errorMsg' => '取消失敗可能原因為簡訊中⼼忙碌， 或是預約簡訊已送出只是狀態尚未更新。',
                        ];
                        break;
                    case '?':
                        $phone = Receiver::select('phone')->where('msgid', $data)->first();
                        $warn .= '門號' . $phone->phone . ' 簡訊序號無效。' . "\r\n";
                        break;                
                    default:
                        $phone = Receiver::select('phone')->where('msgid', $data)->first();
                        $warn .= '門號' . $phone->phone . ' 簡訊已經無法取消預約。' . "\r\n";
                        break;
                }
            }
        }


        if( empty($error) ){
            /* 簡訊預約沒有發生錯誤 */
            Message::where('id', $id)->delete();
            Receiver::where('id_message', $id)->delete();
            if( empty($warn) ){
                /* 簡訊預約沒有發生僅告 */
                return array('status' => 'success');
            }else{
                return array('status' => 'warn', 'msg' => $warn);
            }
        }else{
            return array('status' => 'error', 'msg' => '可能原因為簡訊中⼼忙碌，或是預約簡訊已送出只是狀態尚未更新。');
        }

        // try{

            
        //     return 'success';

        // }catch(\Exception $e){

        //     return 'error';

        // }

    }

    
    /**
     * 刪除訊息
     */
    public function delete(Request $request)
    {
        $id = $request->get('id_message');
        
        try{

            Message::where('id', $id)->delete();
            Receiver::where('id_message', $id)->delete();
            
            return 'success';

        }catch(\Exception $e){

            return 'error';

        }

    }

}
