<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
	 public function role(){
	 	return $this->belongsTo('App\Role');
	 }

	 public function user(){
	 	return $this->belongsTo('App\User');
	 }
}
