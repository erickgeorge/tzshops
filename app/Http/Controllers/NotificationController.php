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

    function readNotification($id){
        $not = Notification::where('id', $id)->first();
        $not->status = 10;
        $not->save();
        
        return redirect()->route('work_order');
    }
}
