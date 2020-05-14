<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class companywitharea extends Model
{
    //
        public function cleaning_area(){
        return $this->belongsTo('App\cleaningarea', 'area_id');
    }
}
