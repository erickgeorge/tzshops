<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class grn extends Model
{
	
	
	
	 public function purchasingorder(){
        return $this->belongsTo('App\PurchasingOrder', 'purchasing_order_id');
    }

   
	
    //
}
