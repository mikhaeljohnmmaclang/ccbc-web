<?php

namespace App\Traits;

use App\Models\Activity_Logs;
use Illuminate\Support\Facades\DB;

trait ActivityLogsTrait
{

    public function saveLogs($admin_id, $admin_name, $action, $ministry_name, $service_name, $member_name, $amount, $status)
    {
        $logs = new Activity_Logs();
        $logs->user_id = $admin_id;
        $logs->admin_name = $admin_name;
        $logs->action = $action;
        $logs->ministry_name = $ministry_name;
        $logs->service_name = $service_name;
        $logs->member_name = ucwords($member_name);
        $logs->amount = number_format($amount);
        if($action == "Set Firstfruit"){
            $logs->description =
            "Set &#8369;" . number_format($amount) . " as Firstfruit Commitment" .
            " for " . ucwords($member_name);
        }else if($action == "Add Transaction"){
            $logs->description =
            "Added &#8369; " . number_format($amount) .
            " to " . $ministry_name .
            " for " . $member_name.
            " at " . $service_name;
        }
        $logs->status = $status;
        $logs->save();
    }
}
