<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Technician;
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
		if($request['checkdiv'] == 'yesmanual') {
			
    	$work_order->location = $request['manual'];
		
		} else {
    	$work_order->room_id = $request['room'];
		}
    	$work_order->client_id = auth()->user()->id;
    	$work_order->problem_type = $request['p_type'];
    	$work_order->details = $request['details'];
    	$work_order->save();

    	return redirect()->route('work_order')->with(['message' => 'Work order successfully created']);
    }

    public function rejectWO(Request $request, $id){
        $wO = WorkOrder::where('id', $id)->first();
       // $wO->staff_id = auth()->user()->id;
        $wO->status = 0;
        $wO->reason = $request['reason'];
        $wO->save();

        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $wO->client_id;
        $notify->type = 'workorder';
        $notify->message = 'Your work order of '.$wO->created_at.' about '.$wO->problem_type.' has been rejected.';
        $notify->save();

//        return response()->json('success');
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

        return redirect()->route('work_order')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order has been rejected',
            'wo' => WorkOrder::where('problem_type',
            substr(strstr( auth()->user()->type, " "), 1))->where('status', '<>' ,0)->get()
        ]);
    }

    public function acceptWO($id){
//        return response()->json($id);
        $wO = WorkOrder::where('id', $id)->first();
        $wO->staff_id = auth()->user()->id;
        $wO->status = 1;
        $wO->save();

        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $wO->client_id;
        $notify->type = 'workorder';
        $notify->message = 'Your work order of '.$wO->created_at.' about '.$wO->problem_type.' has been accepted.';
        $notify->save();

        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

        return redirect()->route('workOrder.edit.view', [$wO->id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'techs' => User::where('type', 'TECHNICIAN')->get(),
            'message' => 'Work order accepted successfully, You can now edit it!',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function editWOView($id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
//        return response()->json(WorkOrder::where('id', $id)->first());
        return view('edit_work_order',[
            'techs' => User::where('type', 'TECHNICIAN')->get(),'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function viewWO($id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
//        return response()->json(WorkOrder::where('id', $id)->first());
        return view('view_work_order',[
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function editWO(Request $request, $id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
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
        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'changes saved successfully',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function fillInspectionForm(Request $request, $id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $mForm = WorkOrderInspectionForm::where('work_order_id', $id)->first();
        if ($mForm){
            $mForm->status = $request['status'];
            $mForm->description = $request['details'];
            $mForm->technician_id = $request['technician'];
            $mForm->save();
        }else{
            $form = new WorkOrderInspectionForm();
            $form->status = $request['status'];
            $form->description = $request['details'];
            $form->technician_id = $request['technician'];
            $form->work_order_id = $id;
            $form->save();
        }

        return redirect()->route('workOrder.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Inspection from successfully updated',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function deletedWOView(){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
		
		if ($role['user_role']['role_id'] == 1){
			            return view('deleted_work_orders', [
			                'role' => $role,
                            'notifications' => $notifications,
                            'wo' => WorkOrder::where('status', 0)->get()
                        ]);
		}
		else
        if (strpos(auth()->user()->type, "HOS") !== false) {
            return view('deleted_work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', 0)->get()
            ]);
        }
        return view('deleted_work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->where('status', 0)->get()
        ]);
    }

    public function redirectToSecretary($id){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $wo = WorkOrder::where('id', $id)->first();
        $wo->problem_type = 'Others';
        $wo->save();
        return redirect()->route('work_order')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order successfully sent to Secretary',
            'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get()
        ]);
    }
}
