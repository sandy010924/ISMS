<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Mdatabase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/* Rocky (2020/02/18) */

class DatabaseController extends Controller
{

    protected $directory = 'backup';

    // 顯示資訊
    public function show()
    {
        $datas = Mdatabase::get();

        return view('frontend.database', compact('datas'));
    }


    public function backup()
    {
        // //备份数据库
        // $backup = Artisan::call('backup:run', ['--only-db' => true]);
        // //这里注意 参数是以数组的形式
        // if ($backup == 0) {
        //     $arr = [
        //         'error' => 0,
        //         'msg' => '数据库备份成功'
        //     ];
        // } else {
        //     $arr = [
        //         'error' => 1,
        //         'msg' => '数据库备份失败'
        //     ];
        // }
        // return $arr;

        // 資料庫設定
        $dumpSettings = array(
            'compress' => IMysqldump\Mysqldump::NONE,
            'no-data' => false,
            'no-create-info' => true,
            'lock-tables' => false,
            'no-autocommit' => false,
            // 'include-tables' => array(),
            // 'exclude-tables' => array(),
            // 'add-drop-table' => true,
            'add-drop-table' => false,
            // 'single-transaction' => true,
            // 'lock-tables' => true,
            'add-locks' => false,
            // 'extended-insert' => true,
            'disable-foreign-keys-check' => true,
            'skip-triggers' => false,
            // 'add-drop-trigger' => true,
            // 'databases' => true,
            // 'add-drop-database' => true,
            // 'hex-blob' => true
        );
        try {
            $dump = new IMysqldump\Mysqldump(
                'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                $dumpSettings
            );
            $filename = date('Y') . date('m') . date('d') . '-' . date('H') .  date('i') . date('s');
            $name = $filename . ".sql";
            $dump->start(storage_path() . "/database/" . $this->directory . '/' . $name);
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }

        // 新增學員資料
        $mdatabase = new Mdatabase();
        $mdatabase->filename       = $name;             // 檔案名稱
        //$mdatabase->reason           = '';              // 日期

        $mdatabase->save();
        $id_mdatabase = $mdatabase->id;

        if (!empty($id_mdatabase)) {
            return '備份成功';
        } else {
            return '備份失敗';
        }
    }

    // 還原資料庫
    public function recover(Request $request)
    {
        $id = $request->get('id');
        $datas = Mdatabase::where('id', $id)
            ->select('m_database.filename')
            ->first();

        $disk = Storage::disk('backup');
        $exists = $disk->exists($this->directory . '/' . $datas['filename']);

        if (!$exists) {
            return '無檔案';
        }

        // 導入SQL
        $sql = file_get_contents(storage_path() . "/database/" . $this->directory . '/' . $datas['filename']);
        // SELECT concat('DELETE FROM ', table_name, ';') FROM information_schema.tables WHERE table_schema = 'isms'

        $sql_drop = "
        SET GLOBAL  FOREIGN_KEY_CHECKS = 0;
        TRUNCATE `blacklist`;
        TRUNCATE `events_course`;
        TRUNCATE `debt`;
        TRUNCATE `mark`;
        TRUNCATE `message`;
        TRUNCATE `migrations`;
        TRUNCATE `m_database`;
        TRUNCATE `notification`;
        TRUNCATE `payment`;
        TRUNCATE `refund`;
        TRUNCATE `register`;
        TRUNCATE `registration`;
        TRUNCATE `rule`;
        TRUNCATE `sales_registration`;
        TRUNCATE `isms_status`;
        TRUNCATE `student`;
        TRUNCATE `student_group`;
        TRUNCATE `student_groupdetail`;
        TRUNCATE `teacher`;
        TRUNCATE `users`; 
        TRUNCATE `course`; ";

        $resul_drop = DB::unprepared($sql_drop);

        if ($resul_drop == 1) {
            $result = DB::unprepared("SET FOREIGN_KEY_CHECKS = 0; " . $sql . "SET FOREIGN_KEY_CHECKS = 1; ");
        }

        if ($result != 1) {
            return '失敗';
        } else {
            return 'ok';
        }
    }
}
