<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
	
	public function location(){
        return $this->belongsTo('App\Location', 'location_id');
    }
	
    //
}
