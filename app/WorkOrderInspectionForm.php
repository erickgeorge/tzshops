<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderInspectionForm extends Model
{
	
	
     public function technician(){
        return $this->belongsTo('App\Technician');

    }
	
	 public function work_order(){
        return $this->belongsTo('App\User', 'work_order_id');
    }
	
		
    //
}
