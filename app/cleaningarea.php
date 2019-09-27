<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cleaningarea extends Model
{

	public function zone(){
        return $this->belongsTo('App\zone');
    }
    	
    //
}
