<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function __construct()
    {
        return $this->middleware('auth');
    }

    function readNotification($id, $type){
        $not = Notification::where('id', $id)->first();
        $not->status = 1;
        $not->save();

        if ($type == 'reject'){
            return redirect()->route('rejected.view.wo');
        }

        return redirect()->route('work_order');
    }
}
