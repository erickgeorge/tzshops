<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderTransport extends Model
{
	
	
	public function requester(){
        return $this->belongsTo('App\User', 'requestor_id');
    }
    public function workorder(){
        return $this->belongsTo('App\WorkOrder','work_order_id');
    }
	
    //
}
