<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkOrder;

class WorkOrderController extends Controller
{
    public function create(Request $request){



    	$request->validate([
            'details' => 'required',
         
        ]);

        if ($request['p_type'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Problem Type required ']);
        }



        if ($request['location'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Location required required ']);
        }













    	$work_order = new WorkOrder();
    	$work_order->room_id = 4;
    	$work_order->client_id = auth()->user()->id;
    	$work_order->problem_type = $request['p_type'];
    	$work_order->details = $request['details'];
    	$work_order->save();

    	return redirect()->route('work_order')->with(['message' => 'Work order successfully created']);
    }
}
