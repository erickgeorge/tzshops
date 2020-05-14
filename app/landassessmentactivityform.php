<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class landassessmentactivityform extends Model
{
	
 public function approval(){
        return $this->belongsTo('App\User', 'accepted_by');
    }

  public function approvalpayment(){
        return $this->belongsTo('App\User', 'approved_by');
    }    

  public function paymentaccountant(){
        return $this->belongsTo('App\User', 'payment_by');
    }   
	

  
}
