<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\session;

class SmsController extends Controller
{

  public function sendSms(Request $Request)
  {
  	 $basic  = new \Nexmo\Client\Credentials\Basic('8f1c6b0f', 'NQSwu3iPSjgw275c');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => '255762391602',
    'from' => 'ESTATE STAFF',
    'text' => '	Your workorder have been closed successfully'
]);

session::flash('message', ' Transport Request Accepted successfully and SMS sent succesifully to Store Manager');

return redirect('/work_order_material_needed');
}
}
   