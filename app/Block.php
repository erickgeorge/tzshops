<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
	
	public function area(){
        return $this->belongsTo('App\Area', 'area_id');
    }
    //
}
