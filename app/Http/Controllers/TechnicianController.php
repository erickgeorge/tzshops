<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Technician;
use App\User;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function techView(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('add_tech', [
            'role' => $role,
            'notifications' => $notifications
            ]);
    }

    public function createTech(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required|max:15|min:10',
            'email' => 'required|unique:technicians'
        ]);

        $tech = new Technician();
        $tech->fname = $request['fname'];
        $tech->lname = $request['lname'];
        $tech->phone = $request['phone'];
        $tech->email = $request['email'];
        $tech->type = substr(strstr(auth()->user()->type, " "), 1);
        $tech->save();

        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return redirect()->route('techs.view')->with([
            'role' => $role,
            'message' => 'Technician Created Successfully',
            'techs' => Technician::where('type', substr(strstr(auth()->user()->type, " "), 1))->get(),
            'notifications' => $notifications
        ]);
    }

    public function editTechView($id){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('edit_tech', [
            'tech' => Technician::find($id),
            'role' => $role,
            'notifications' => $notifications
        ]);
    }

    public function editTech(Request $request, $id){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required|max:15|min:10',
            'email' => 'required'
        ]);

        $tech = Technician::find($id);
        $tech->fname = $request['fname'];
        $tech->lname = $request['lname'];
        $tech->phone = $request['phone'];
        $tech->email = $request['email'];
        $tech->save();

        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return redirect()->route('tech.edit', $id)->with([
            'role' => $role,
            'message' => 'Technician Edited Successfully',
            'notifications' => $notifications
        ]);
    }

    public function deleteTech($id){
        Technician::find($id)->delete();
        return redirect()->back()->with(['message', 'Technician deleted']);
    }
}