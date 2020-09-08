<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Mdatabase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\Storage;

/* Rocky (2020/02/18) */

class DatabaseController extends Controller
{
    protected $directory = 'backup';

    // 顯示資訊
    public function show()
    {
        $datas = Mdatabase::orderby('created_at', 'desc')
            ->take(5)->get();

        return view('frontend.database', compact('datas'));
    }


    public function delete()
    {
        $status = "";
        $check_delete = "";

        // 抓取資料
        $datas = Mdatabase::join(
            DB::raw('(SELECT ID FROM m_database ORDER BY created_at DESC limit 4,100) as b'),
            function ($join) {
                $join->on("m_database.id", "=", "b.id");
            }
        )
            ->select('m_database.id', 'm_database.filename')
            ->get();


        // 確認是否有檔案
        $disk = Storage::disk('backup');
        foreach ($datas as $key => $data) {
            $exists = $disk->exists($this->directory . '/' . $data['filename']);

            if ($exists) {
                // 刪除檔案
                $check_delete = $disk->delete($this->directory  . '/' . $data['filename']);
            }
        }

        if ($datas != "" && $check_delete) {
            Mdatabase::join(
                DB::raw('(SELECT ID FROM m_database ORDER BY created_at DESC limit 4,100) as b'),
                function ($join) {
                    $join->on("m_database.id", "=", "b.id");
                }
            )
                ->select('m_database.id', 'm_database.filename')
                ->delete();
            $status = "ok";
        } else {
            $status = "error";
        }
        return $status;
    }

    public function backup()
    {        // 資料庫設定
        $dumpSettings = array(
            'compress' => IMysqldump\Mysqldump::NONE,
            'no-data' => false,
            'no-create-info' => true,
            'lock-tables' => false,
            'no-autocommit' => false,
            'add-drop-table' => false,
            'add-locks' => false,
            'disable-foreign-keys-check' => true,
            'skip-triggers' => false,
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

        // 新增資料
        $mdatabase = new Mdatabase();
        $mdatabase->filename       = $name;             // 檔案名稱

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
        TRUNCATE `blacklist`;
        TRUNCATE `events_course`;
        TRUNCATE `debt`;
        TRUNCATE `mark`;
        TRUNCATE `message`;
        TRUNCATE `migrations`;
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
        TRUNCATE `course`;        
        TRUNCATE `receiver`;
        TRUNCATE `bonus_rule`;
        TRUNCATE `bonus`;   
        TRUNCATE `activity`;                
        TRUNCATE `m_database`;";

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $resul_drop = DB::unprepared($sql_drop);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if ($resul_drop == 1) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            $result = DB::unprepared($sql);
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        if ($result != 1) {
            return '失敗';
        } else {
            return 'ok';
        }
    }
}
