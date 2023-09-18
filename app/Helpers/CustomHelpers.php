<?php

use App\Models\ActivityLog;

if (!function_exists('add_activity_logs')) {
    function add_activity_logs($data = [])
    {

        if ($data && $data['user_id'] && $data['activity_type']) {
            $acivity_logged = ActivityLog::create($data);
            if ($acivity_logged) {
                return $acivity_logged;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
}
