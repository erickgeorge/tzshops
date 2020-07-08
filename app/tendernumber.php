<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tendernumber extends Model
{
     public function tendercompany(){
        return $this->belongsTo('App\companywitharea' , 'company');
    }
}
