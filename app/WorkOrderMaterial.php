<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderMaterial extends Model
{
	
	
	public function updated_by(){
        return $this->belongsTo('App\User', 'status_updater_id');
    }
    public function workorder(){
        return $this->belongsTo('App\WorkOrder','work_order_id');
    }
	
	public function material(){
        return $this->belongsTo('App\Material','material_id');
    }
	
	public function usermaterial(){
        return $this->belongsTo('App\User','hos_id');
    }
    //
}
