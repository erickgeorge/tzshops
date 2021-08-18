<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
     public function up(){
        return $this->belongsTo('App\user' , 'updated');
    }
}
