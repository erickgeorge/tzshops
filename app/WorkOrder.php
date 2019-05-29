<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'client_id');
    }
    public function room(){
        return $this->belongsTo('App\Room');
    }

public function work_order_progress(){
        return $this->hasOne('App\WorkOrderProgress');
    }

}

