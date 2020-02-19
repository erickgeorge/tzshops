<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class landscapinginspectionform extends Model
{
	

	 public function work_order(){
        return $this->belongsTo('App\User', 'work_order_id');
    }
	
		
  
}
