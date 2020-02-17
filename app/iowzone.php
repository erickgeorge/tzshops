<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class iowzone extends Model
{
	
	
	public function user(){
        return $this->belongsTo('App\User', 'iow');
    }


}
