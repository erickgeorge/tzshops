<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasingOrder extends Model
{
	
	
	
	 public function workorder(){
        return $this->belongsTo('App\User', 'work_order_id');
    }

    public function material(){
        return $this->belongsTo('App\Material', 'material_list_id');
    }
	
    //
}
