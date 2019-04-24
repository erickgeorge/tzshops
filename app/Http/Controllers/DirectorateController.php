<?php

namespace App\Http\Controllers;

use App\Department;
use App\Directorate;
use App\Location;
use App\Section;
use App\User;
use Illuminate\Http\Request;

class DirectorateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function departmentsView(){
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('manage_dep', [
            'role' => $role,
            'directorates' => Directorate::all(),
            'deps' => Department::with('directorate')->paginate(10),
            'secs' => Section::with('department')->paginate(10)
        ]);
    }

    public function createDirectorate(Request $request)
    {
        /*$request->validate([
            'dir_name' => 'required|unique:directorates',
            'dir_abb' => 'required|unique:directorates'
        ]);*/

        if ($request['location'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Campus is required']);
        }

        if (Directorate::where('directorate_description',$request['dir_name'])->first() || Directorate::where('name',$request['dir_abb'])->first()){
            return redirect()->back()->withErrors(['message' => 'Directorate already exist']);
        }

        $directorate = new Directorate();
        $directorate->directorate_description = $request['dir_name'];
        $directorate->name = $request['dir_abb'];
        $directorate->campus_id = 1;
        $directorate->save();

        return redirect()->route('dir.manage')->with(['message' => 'Directorate added successfully']);
    }

    public function createDepartment(Request $request)
    {
        /*$request->validate([
            'dep_name' => 'required|unique:directorates',
            'dep_ab' => 'required|unique:directorates'
        ]);*/

        if ($request['directorate'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Directorate is required']);
        }

        if (Department::where('description',$request['dep_name'])->first() || Department::where('name',$request['dep_ab'])->first()){
            return redirect()->back()->withErrors(['message' => 'Department already exist']);
        }

        $dpeartment = new Department();
        $dpeartment->description = $request['dep_name'];
        $dpeartment->name = $request['dep_ab'];
        $dpeartment->directorate_id = $request['directorate'];
        $dpeartment->save();

        return redirect()->route('dir.manage')->with(['message' => 'Department added successfully']);
    }

    public function createSection(Request $request)
    {
        /*$request->validate([
            'sec_ab' => 'required|unique:directorates',
            'sec_name' => 'required|unique:directorates'
        ]);*/

        if ($request['department'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Department is required']);
        }

        if (Section::where('description',$request['section_name'])->first() || Section::where('description',$request['sec_ab'])->first()){
            return redirect()->back()->withErrors(['message' => 'Section already exist']);
        }

        $section = new Section();
        $section->description = $request['sec_name'];
        $section->section_name = $request['sec_ab'];
        $section->department_id = $request['department'];
        $section->save();

        return redirect()->route('dir.manage')->with(['message' => 'Department added successfully']);
    }
}
