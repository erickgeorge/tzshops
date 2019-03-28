<?php

namespace App\Http\Controllers;

use App\User;
use App\WorkOrderInspectionForm;
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
    	$work_order->room_id = $request['room'];
    	$work_order->client_id = auth()->user()->id;
    	$work_order->problem_type = $request['p_type'];
    	$work_order->details = $request['details'];
    	$work_order->save();

    	return redirect()->route('work_order')->with(['message' => 'Work order successfully created']);
    }

    public function rejectWO($id){
        $wO = WorkOrder::where('id', $id)->first();
        $wO->staff_id = auth()->user()->id;
        $wO->status = 0;
        $wO->save();

//        return response()->json('success');
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();

        return redirect()->route('work_order')->with(['role' => $role, 'wo' => WorkOrder::where('problem_type',
            substr(strstr( auth()->user()->type, " "), 1))->where('status', '<>' ,0)->get()]);
    }

    public function acceptWO($id){
//        return response()->json($id);
        $wO = WorkOrder::where('id', $id)->first();
        $wO->staff_id = auth()->user()->id;
        $wO->status = 1;
        $wO->save();

        $role = User::where('id',auth()->user()->id)->with('user_role')->first();

        return redirect()->route('work_order')->with(['role' => $role, 'wo' => WorkOrder::where('problem_type',
            substr(strstr( auth()->user()->type, " "), 1))->where('status', '<>' ,0)->get()]);
    }

    public function viewWO($id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
//        return response()->json(WorkOrder::where('id', $id)->first());
        return view('view_work_order',['role' => $role, 'wo' => WorkOrder::where('id', $id)->first()]);
    }

    public function editWO(Request $request, $id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $wo = WorkOrder::where('id', $id)->first();
        if (isset($request['emergency'])){
            $wo->emergency = 1;
        }else{
            $wo->emergency = 0;
        }
        if (isset($request['labour'])){
            $wo->needs_laboured = 1;
        }else{
            $wo->needs_laboured = 0;
        }
        if (isset($request['contractor'])){
            $wo->needs_contractor = 1;
        }else{
            $wo->needs_contractor = 0;
        }
        $wo->save();
        return redirect()->route('workOrder.view', [$id])->with([
            'role' => $role,
            'message' => 'changes saved successfully',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function fillInspectionForm(Request $request, $id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $mForm = WorkOrderInspectionForm::where('work_order_id', $id)->first();
        if ($mForm){
            $mForm->status = $request['status'];
            $mForm->description = $request['details'];
            $mForm->nameOfTechnician = $request['name_tech'];
            $mForm->save();
        }else{
            $form = new WorkOrderInspectionForm();
            $form->status = $request['status'];
            $form->description = $request['details'];
            $form->nameOfTechnician = $request['name_tech'];
            $form->work_order_id = $id;
            $form->save();
        }

        return redirect()->route('workOrder.view', [$id])->with([
            'role' => $role,
            'message' => 'Inspection from successfully updated',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }
}
