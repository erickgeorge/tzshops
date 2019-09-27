<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class zone extends Model
{
	
	
	public function Campus(){
        return $this->belongsTo('App\Campus');
    }
    	


}
