<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderStaff extends Model
{
	
	
	public function technician(){
        return $this->belongsTo('App\User', 'staff_id');
    }
    public function workorder(){
        return $this->belongsTo('App\WorkOrder');
    }
	
    //
}
