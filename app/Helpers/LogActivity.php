<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{
    public static function makeLog($subject, Request $request)
    {
        $log = [];

        $log['subject'] = $subject;
        $log['url'] = $request->fullUrl();
        $log['method'] = $request->method();
        $log['author_id'] = auth()->check() ? auth()->user()->id : null;

        LogActivityModel::create($log);
    }
}
