<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    //

 public function technician_assigned(){
        return $this->hasOne('App\WorkOrderStaff');
    }
}
