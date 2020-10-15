<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class block extends Model
{
	
	public function areas(){
        return $this->belongsTo('App\area', 'area_id');
    }
    //
}
