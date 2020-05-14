<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class landassessmentform extends Model
{
	
    
     public function companyname(){
        return $this->belongsTo('App\company','company_id');
    }


	 public function areaname(){
        return $this->belongsTo('App\cleaningarea', 'area_id');
    }
	

	 public function workorder(){
        return $this->belongsTo('App\landworkorders', 'work_order_id');
    }

     public function assessorname(){
        return $this->belongsTo('App\User', 'assessor');
    }

	


  
}
