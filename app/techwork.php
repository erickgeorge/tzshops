<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class techwork extends Model
{
    //
	
		public function technician_work(){
        return $this->belongsTo('App\Technician', 'staff_id');
    }
}
