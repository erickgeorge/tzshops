<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desdepartment extends Model
{   
  public function Des(){
        return $this->belongsTo('App\Des' , 'des_id');
    }

    //
}
