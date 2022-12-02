<?php


namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait WriteLog {

    function writeLogSyncOrderStatistics(string $msg, string $data, string $command) {
        $time = date('Y-m-d H:i:s');
        DB::insert('INSERT INTO `api_logs` (method, request_url, request_header,request_string,response_string,user_id,token,request_ip,device_type,duration,platform,agent_info,created_at)
            values (?,?,?,?,?,?,?,?,?,?,?,?,?)',
            ["COMMAND", $command,"",$msg, $data,"","","","","","","",$time]);
    }
}
