<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Sender;

class MessageListController extends Controller
{
    /**
     * 刪除訊息
     */
    public function delete(Request $request)
    {
        $id = $request->get('id_message');
        
        try{

            Message::where('id', $id)->delete();
            Sender::where('id_message', $id)->delete();
            
            return 'success';

        }catch(\Exception $e){

            return 'error';

        }

    }

}
