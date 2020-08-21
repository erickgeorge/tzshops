<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;
use App\Technician;
use App\User;
use App\Notification;



class PDFController extends Controller
{



     public function htmlPDF58(){

     $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

    return view('htmlPDF', [
            'role' => $role,
            'techs' => Technician::where('status',0)->where('type', substr(strstr(auth()->user()->type, " "), 1))->orderBy('fname','ASC')->get(),
            'notifications' => $notifications

        ]);
   }






    public function generatePDF58()
    {
        $data = ['title' => 'Laravel 5.8 HTML to PDF' ,'notifications' => Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get(), 'role' => User::where('id', auth()->user()->id)->with('user_role')->first(),'techs' => Technician::where('status',0)->where('type', substr(strstr(auth()->user()->type, " "), 1))->orderBy('fname','ASC')->get(), ];
        $pdf = PDF::loadView('htmlPDF', $data);
        return $pdf->download('demonutslaravel.pdf');
    }


}
