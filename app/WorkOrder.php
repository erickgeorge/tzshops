<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'client_id');
    }

     public function onbehalfs(){
        return $this->belongsTo('App\User', 'onbehalf');
    }
	
	 public function hos(){
        return $this->belongsTo('App\User', 'staff_id');
    }
    public function room(){
        return $this->belongsTo('App\Block');
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


    public function work_order_staffassigned(){
        return $this->hasOne('App\techasigned');
    }   

    public function iowrejected(){
        return $this->belongsTo('App\User', 'iowsatisfied');
    }


    public function hoscloses(){
        return $this->belongsTo('App\User','hosclose');
    }

    public function iowcloses(){
        return $this->belongsTo('App\User','iowclose');
    }

      public function clientcloses(){
        return $this->belongsTo('App\User','clientclose');
    }

          public function hos2close(){
        return $this->belongsTo('App\User','hosclose2');
    }



}

