<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class techasigned extends Model
{
	
    public function technician_assigned_for_inspection(){
        return $this->belongsTo('App\Technician', 'staff_id');
    }
    
	
    //
}
