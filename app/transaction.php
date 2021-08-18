<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
	 public function up(){
        return $this->belongsTo('App\user' , 'updated');
    }
}
