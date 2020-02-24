<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class landscapinginspectionform extends Model
{
	
    
     public function usersupervior(){
        return $this->belongsTo('App\User', 'supervisor');
    }


	 public function work_order(){
        return $this->belongsTo('App\User', 'work_order_id');
    }
	


  
}
