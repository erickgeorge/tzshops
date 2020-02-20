<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class  iowzonelocation extends Model
{
		
		public function iow(){
        return $this->belongsTo('App\iowzone','iowzone_id');
    }


}
