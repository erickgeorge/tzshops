<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class landassessmentform extends Model
{
	
    
     public function company(){
        return $this->belongsTo('App\company', 'company_id');
    }


	 public function area(){
        return $this->belongsTo('App\Area', 'area_id');
    }
	


  
}
