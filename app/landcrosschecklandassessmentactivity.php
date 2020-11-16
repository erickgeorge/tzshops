<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class landcrosschecklandassessmentactivity extends Model
{
	
 public function approval(){
        return $this->belongsTo('App\User', 'accepted_by');
    }

  public function approvalpayment(){
        return $this->belongsTo('App\User', 'approved_by');
    }    

  public function approvaldvc(){
        return $this->belongsTo('App\User', 'dvc_accepted_by');
    }  

  public function paymentaccountant(){
        return $this->belongsTo('App\User', 'payment_by');
    }   


  public function rejection(){
        return $this->belongsTo('App\User', 'a_rejected_by');
    }  


      public function rejectionestate(){
        return $this->belongsTo('App\User', 'es_rejected_by');
    } 



      public function rejectiondvc(){
        return $this->belongsTo('App\User', 'dvc_rejected_by');
    } 
  

      public function assessmentid(){
        return $this->belongsTo('App\company', 'assessment_id');
    } 


        public function cleaningarea(){
        return $this->belongsTo('App\cleaningarea', 'area_id');
    } 

        public function initiated(){
        return $this->belongsTo('App\User', 'initiated_by');
    } 

        public function deanstudent(){
        return $this->belongsTo('App\User', 'dean');
    } 


            public function deputyuser(){
        return $this->belongsTo('App\User', 'deputy');
    } 

            public function principles(){
        return $this->belongsTo('App\User', 'principle');
    } 

            public function deanreject(){
        return $this->belongsTo('App\User', 'dean_rejected_by');
    } 
  

  
}
