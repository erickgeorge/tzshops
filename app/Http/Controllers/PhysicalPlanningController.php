<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
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

    public function postinfrastructureproject(Request $request)
    {
		$request->validate([
            'projectname' => 'required',
            'projectdescription'=>'required',
        ]);

			$newplan = new ppuproject;
			$newplan->project_name = $request['projectname'];
			$newplan->description = $request['projectdescription'];
            $newplan->Created_by = auth()->user()->id;
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
			$newstatus->remarks = $request['reason'];
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

	public function ppudraftsdraws(Request $request)
	{


        $this->validate($request,['file' => 'required|mimes:pdf,doc,docx,xls,ppt,xlsx|max:2048',]);


		$drawings = new ppuprojectdrawing;
		$document = new ppudocument;
		$currentIdentifier = Now();

		$drawings->project_id = $request['projectid'];
		$drawings->document_identifier = $currentIdentifier;
		$drawings->description = $request['description'];
		$drawings->drawn_by = $request['author'];
		$drawings->save();



      $path = public_path('documents/ppu-'.$request['projectid']);
      if(!File::isDirectory($path))
      {
        File::makeDirectory($path,$mode = 0777, true, true);
      }

      if($file = $request->file('file'))
      {
          $filename = time().'-'.$request['projectid'].'.'.$file->getClientOriginalExtension();
          $targetpath = $path;

          if($file->move($targetpath, $filename))
          {
            $document->document_identifier = $currentIdentifier;
            $document->doc_name = $filename;
            $document->type = $file->getClientOriginalExtension();
            $document->updated_by = auth()->user()->id;
            $document->save();
          }
      }

            $projectstatus = ppuproject::where('id',$request['projectid'])->first();

			$newstatus = new ppuprojectprogress;
			$newstatus->project_id = $request['projectid'];
			$newstatus->date_entered = $projectstatus['created_at'];
			$newstatus->status = 5;
			$newstatus->updated_by = auth()->user()->id;
            $newstatus->save();

			$projectstatus->status = 5;
            $projectstatus->save();

      return redirect()->route('ppuprojectview', [$request['projectid']])->with(['message' => 'Project Drawings and plans uploaded Succesfully!']);


    }

    public function viewppudraws($id, $type, $name)
    {

        $path = public_path('documents/ppu-'.$id.'/'.$name);

        return response()->file($path);
    }

    public function ppuforwardplanDvcAdmin($id)
    {
        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 11;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 11;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Plans Sent to Director DES Succesfully!']);

    }

    public function ppuforwardplanDES($id)
    {
        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 6;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 6;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Plans Sent to DVC Admin Succesfully!']);

    }

    public function ppuApproveplanDES($id)
    {
        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 7;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 7;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Plans Approved Succesfully!']);

    }

    public function ppuForwardDVCppu($id)
    {
        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 12;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 12;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Plans Sent to Head PPU Succesfully!']);


    }

    public function ppuForwardPlansQS(Request $request)
    {
        $id = $request['projectid'];
        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 8;
        $newstatus->remarks = $request['description'];
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 8;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Plans Forwarded to Quality Surveyor Succesfully!']);

    }

    public function ppuForwardBudgetppu(Request $request)
    {
   /*

*/


        $z = 0;
        $total = $request['totalinputs']/2;


        for($i=1; $i<=$total; $i++) {
            $budget = new ppuprojectbudget;
            $z++;
            $budget->project_id = $request['projectid'];
            $budget->budget_item =  $request[$z];
            $z++;
            $budget->amount = $request[$z];
			$budget->save();

        }



        $id = $request['projectid'];
        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 9;
        $newstatus->remarks = $request['description'];
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 9;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Budget Forwarded to Head PPU Succesfully!']);
    }

    public function pputrack($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $project = ppuproject::where('id',$id)->first();
        $progress = ppuprojectprogress::where('project_id',$id)->orderBY('id','ASC')->get();
        $document = ppuprojectdrawing::where('project_id',$id)->first();
        $file = ppudocument::where('document_identifier',$document['document_identifier'])->get();
        $budget = ppuprojectbudget::where('project_id',$id)->orderBy('budget_item','ASC')->get();
        return view('pputrack',
            [
                'role' => $role,
                'notifications' => $notifications,
                'project' => $project,
                'progress' => $progress,
                'document' => $document,
                'file' => $file,
                'budget' => $budget
            ]);

    }

    public function ppubudgetAppoveDES($id)
    {

        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 10;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 10;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Budget Sent to Director DES For Approval Succesfully!']);

    }

    public function ppubudgetAppoveDVC($id)
    {

        $projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 13;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 13;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Budget Sent to Director DVC Admin For Approval Succesfully!']);


    }

    public function ppubudgetApprovedDVC($id)
    {$projectstatus = ppuproject::where('id',$id)->first();

        $newstatus = new ppuprojectprogress;
        $newstatus->project_id = $id;
        $newstatus->date_entered = $projectstatus['created_at'];
        $newstatus->status = 14;
        $newstatus->updated_by = auth()->user()->id;
        $newstatus->save();

        $projectstatus->status = 14;
        $projectstatus->save();

        return redirect()->route('ppuprojectview', [$id])->with(['message' => 'Project Budget Approved Succesfully!']);


    }

    public function ppudrawingslibrary()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $projectdrawing = ppuprojectdrawing::orderby('id','DESC')->get();


       return view('ppudrawingslibrary', ['drawingdetails'=> $projectdrawing ,'role' => $role, 'notifications' => $notifications,]);
    }

    public function ppudrawingsview($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $projectdrawing = ppuprojectdrawing::where('id',$id)->first();
        $projectfile = ppudocument::where('document_identifier',$projectdrawing['document_identifier'])->get();
        $projectinfo = ppuproject::where('id',$projectdrawing['project_id'])->first();
        $userinfo = User::where('id',$projectinfo['Created_by'])->first();
        $status = ppuprojectprogress::where('project_id',$projectdrawing['project_id'])->where('status',4)->first();

        return view('ppudrawingsview', ['status'=>$status,'userinfo'=>$userinfo,'projectinfo'=>$projectinfo,'projectfile' => $projectfile,'projectdrawing'=> $projectdrawing ,'role' => $role, 'notifications' => $notifications,]);

    }

    public function ppubudgetlibrary()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $projectbudget = ppuprojectbudget::select('project_id')->distinct()->get();

       return view('ppubudgetlibrary', ['budgetdetails'=> $projectbudget ,'role' => $role, 'notifications' => $notifications,]);

    }

    public function ppubudgetview($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $projectbudget = ppuprojectbudget::where('project_id',$id)->get();

       return view('ppubudgetview', ['budgetdetails'=> $projectbudget ,'role' => $role, 'notifications' => $notifications,]);

    }
}
