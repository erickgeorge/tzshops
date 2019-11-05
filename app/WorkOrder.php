<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'client_id');
    }
	
	 public function hos(){
        return $this->belongsTo('App\User', 'staff_id');
    }
    public function room(){
        return $this->belongsTo('App\Room');
    }
    public function inspectionForm(){
        return $this->hasOne('App\WorkOrderInspectionForm');
    }

      public function work_order_progress(){
        return $this->hasOne('App\WorkOrderProgress');
    }
	
	
    public function work_order_inspection(){
        return $this->hasOne('App\WorkOrderInspectionForm');
    }	


public function work_order_transport(){
        return $this->hasOne('App\WorkOrderTransport');
    }	
	
	public function work_order_staff(){
        return $this->hasOne('App\WorkOrderStaff');
    }	

public function work_order_material(){
        return $this->hasOne('App\WorkOrderMaterial');
    }	






}

