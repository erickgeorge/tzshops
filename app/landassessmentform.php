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
	

     public function assessorname(){
        return $this->belongsTo('App\User', 'assessor');
    }

    public function assessmentname(){
        return $this->belongsTo('App\assessmentsheet', 'assessment_id');
    }

	


  
}
