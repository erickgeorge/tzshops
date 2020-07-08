<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
	  public function are_a(){
        return $this->belongsTo('App\cleaningarea' , 'area');
    }

      public function compantwo(){
        return $this->belongsTo('App\companywitharea' , 'company_name');
    }


}
