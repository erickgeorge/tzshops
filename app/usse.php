<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usse extends Model
{
        public function us(){
        return $this->belongsTo('App\user' , 'keeper');
    }
        public function up(){
        return $this->belongsTo('App\user' , 'updated');
    }
}
