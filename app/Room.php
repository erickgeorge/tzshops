<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function block(){
        return $this->belongsTo('App\Block');
    }

      public function area(){
        return $this->belongsTo('App\area', 'area_id');
    }
}
