<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\house;
use App\hall;
use App\Notification;
use App\user;
use App\Campus;
use App\zone;
use App\cleaningarea;
use App\NonBuildingAsset;
use App\Area;
use App\Room;
use App\Block;
use App\Location;
use App\ppuproject;
use App\ppucontract;
use App\ppudocument;
use App\ppuprojectbudget;
use App\ppuprojectconsultant;
use App\ppuprojectcontractor;
use App\ppuprojectdrawing;
use App\ppuprojectpayment;
use App\ppuprojectprogress;
use App\ppuprojecttender;
use App\ppuprojecttor;
use App\contractor;

class PhysicalPlanningController extends Controller
{

	public function physicalplanning()
	{
		 $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();


       
       return view('ppu', [ 'role' => $role, 'notifications' => $notifications,]);
	}

	public function infrastructureproject()
	{
		$notifications = Notification::where('receiver_id', auth()->user()->id)->get();
		$project = ppuproject::orderby('id','DESC')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
       return view('ppuinfrastructureprojects', [ 'role' => $role, 'notifications' => $notifications,'projects'=>$project]);
	}

	public function newinfrastructureproject()
	{
		$notifications = Notification::where('receiver_id', auth()->user()->id)->get();
 $role = User::where('id', auth()->user()->id)->with('user_role')->first();
       return view('ppunewinfrastructureproject', [ 'role' => $role, 'notifications' => $notifications]);
	}

	public function postinfrastructureproject(Request $request){
		$request->validate([
            'projectname' => 'required',
            'projectdescription'=>'required',
        ]);

			$newplan = new ppuproject;
			$newplan->project_name = $request['projectname'];
			$newplan->description = $request['projectdescription'];

			$newplan->save();

			$status = ppuproject::where('project_name',$request['projectname'])->where('description',$request['projectdescription'])->first();

			$newstatus = new ppuprojectprogress;
			$newstatus->project_id = $status->id;
			$newstatus->date_entered = $status->created_at;
			$newstatus->status = 0;
			$newstatus->updated_by = auth()->user()->id;
			$newstatus->save();


return redirect()->route('infrastructureproject')->with(['message' => 'Infrastructure Project Created and Saved Succesfully']);
	}

	public function ppuprojectview($id)
	{
		$notifications = Notification::where('receiver_id', auth()->user()->id)->get();
		$project = ppuproject::where('id',$id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
       return view('ppuprojectview', [ 'role' => $role, 'notifications' => $notifications,'projects'=>$project]);
	}

	public function ppuprojectforwarddvc($id)
	{
		$newstatus = new ppuprojectprogress;
			$newstatus->project_id = $id;
			$newstatus->date_entered = now();
			$newstatus->status = 1;
			$newstatus->updated_by = auth()->user()->id;
			$newstatus->save();

		$projectstatus = ppuproject::where('id',$id)->first();
		$projectstatus->status = 1;
		$projectstatus->save();	

	return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Forwarded to DVC Succesfully!']);
	}
	public function ppueditproject($id)
	{
		$notifications = Notification::where('receiver_id', auth()->user()->id)->get();
		$project = ppuproject::where('id',$id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
       return view('ppueditproject', [ 'role' => $role, 'notifications' => $notifications,'projects'=>$project]);
	}
	public function saveeditedproject(Request $request)
	{		
		$request->validate([
            'projectname' => 'required',
            'projectdescription'=>'required',
        ]);
			$newplan = ppuproject::where('id',$request['projectid'])->first();
			$newplan->project_name = $request['projectname'];
			$newplan->description = $request['projectdescription'];
			if($request['reedit']==1)
			{
				$newplan->status = 0;



				$newstatus = new ppuprojectprogress;
				$newstatus->project_id = $newplan->id;
				$newstatus->date_entered = $newplan->created_at;
				$newstatus->status = 0;
				$newstatus->updated_by = auth()->user()->id;
				$newstatus->save();
			}
			$newplan->save();

		return redirect()->route('ppuprojectview', $request['projectid'])->with(['message' => 'Project Updated Succesfully!']);
	}

	public function ppurejectproject(Request $request)
	{
		$request->validate([
            'reason'=>'required',
        ]);

		$newstatus = new ppuprojectprogress;
			$newstatus->project_id = $request['projectid'];
			$newstatus->date_entered = now();
			$newstatus->notification = $request['reason'];
			$newstatus->status = -1;
			$newstatus->updated_by = auth()->user()->id;
			$newstatus->save();

	return redirect()->route('infrastructureproject')->with(['message' => 'Project Rejected!']);
	}

	public function ppuprojectforwarddes($id)
	{
			$newstatus = new ppuprojectprogress;
			$newstatus->project_id = $id;
			$newstatus->date_entered = now();
			$newstatus->status = 2;
			$newstatus->updated_by = auth()->user()->id;
			$newstatus->save();

		$projectstatus = ppuproject::where('id',$id)->first();
		$projectstatus->status = 2;
		$projectstatus->save();	

	return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Forwarded to Director DES Succesfully!']);
	}

	public function ppuprojectforwardppu($id)
	{
		$newstatus = new ppuprojectprogress;
			$newstatus->project_id = $id;
			$newstatus->date_entered = now();
			$newstatus->status = 3;
			$newstatus->updated_by = auth()->user()->id;
			$newstatus->save();

		$projectstatus = ppuproject::where('id',$id)->first();
		$projectstatus->status = 3;
		$projectstatus->save();	

	return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Forwarded to Head PPU Succesfully!']);
	}

	public function ppuprojectdraftsman(request $request)
	{
				$projectstatus = ppuproject::where('id',$request['projectid'])->first();

				$newstatus = new ppuprojectprogress;
				$newstatus->project_id = $request['projectid'];
				$newstatus->date_entered = $projectstatus['created_at'];
				$newstatus->status = 4;
				$newstatus->remarks = $request['reason'];
				$newstatus->updated_by = auth()->user()->id;
				$newstatus->save();

				
				$projectstatus->status = 4;
				$projectstatus->save();	

			return redirect()->route('ppuprojectview', [$request['projectid']])->with(['message' => 'Project Accepted and Forwarded to Draftsman Succesfully!']);
	}
}