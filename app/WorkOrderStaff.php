<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderStaff extends Model
{
	
	
	public function technician_assigned(){
        return $this->belongsTo('App\Technician', 'staff_id');
    }

    public function technician_assigned_for_inspection(){
        return $this->belongsTo('App\Technician', 'staf_id');
    }
    public function workorder(){
        return $this->belongsTo('App\WorkOrder');
    }
	
    //
}
