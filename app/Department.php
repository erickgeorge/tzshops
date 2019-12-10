<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{   
  public function directorate(){
        return $this->belongsTo('App\Directorate' , 'directorate_id');
    }

    //
}
