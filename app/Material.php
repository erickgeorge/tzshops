<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
	
		public function work_order_material(){
        return $this->hasOne('App\WorkOrderMaterial');
    }	
}
