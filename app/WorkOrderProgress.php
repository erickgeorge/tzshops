<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderProgress extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'updated_by');
    }
    public function work_order(){
        return $this->belongsTo('App\WorkOrder', 'work_order_id');
    }
}
