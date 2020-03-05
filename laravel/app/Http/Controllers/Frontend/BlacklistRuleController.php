<?php
namespace App\Http\Controllers\Frontend;

use App\Model\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Rocky (2020/02/18) */
class BlacklistRuleController extends Controller
{
   
    // 顯示資訊
    public function show()
    {
        $datas = Rule::get();

        return $datas;
    }
}
