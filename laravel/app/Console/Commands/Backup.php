<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use App\Model\Mdatabase;
use Ifsnop\Mysqldump as IMysqldump;
// use Illuminate\Support\Facades\Storage;
use Carbon;
use Storage;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isms:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'isms自動備份';

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
        $directory = 'backup';

        // 資料庫設定
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
            $dump->start(storage_path() . "/database/" . $directory . '/' . $name);
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }
        // 檔案紀錄在 storage/test.log
        $log_filename = date('Y') . date('m') . date('d');
        $log_file_path = storage_path() . "/logs/" . $log_filename . ".txt";

        $disk = Storage::disk('backup');
        $exists = $disk->exists($directory . '/' . $name);
        if ($exists) {
            // 新增資料
            $mdatabase = new Mdatabase();
            $mdatabase->filename       = $name;             // 檔案名稱

            $mdatabase->save();
            $id_mdatabase = $mdatabase->id;


            // 記錄當時的時間
            $log_info = date('Y-m-d H:i:s');

            if (!empty($id_mdatabase)) {
                // 記錄 JSON 字串
                $log_info_json =  $log_info . $id_mdatabase . "備份成功 \r\n";
            } else {
                $log_info_json =  $log_info . "備份失敗 \r\n";
            }
        } else {
            $log_info_json =  $log_info . "備份失敗!! \r\n";
        }
        // 記錄 Log
        File::append($log_file_path, $log_info_json);
    }
}
