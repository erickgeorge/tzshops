@extends('layouts.master')

@section('title')
    {{ $head }}
    @endSection
@section('body')
    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style="text-transform: capitalize;"   >{{ $head }}</h5>
        </div>
    </div>
    @if(Session::has('message'))
        <br>
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
     @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif
    <br>
    <hr>

    <div class="container">


         <?php
use App\User;
use App\Technician;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
use Carbon\Carbon;


 ?>
 <?php
      $maintenance_coordinator = '';
$hoos = user::select('type')->where('id',auth()->user()->id)->get();
foreach ($hoos as $hous) {
   $hotype = $hous->type;
        if(substr($hotype,0,4) == 'HOS '){

          echo '<a style="margin-left: 2%;" href="add/technician">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new technician</button></a> ';
          }
          elseif($hotype == 'Maintenance coordinator'){
            echo '<a style="margin-left: 2%;" href="add/technician">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new technician</button></a> ';

          }elseif($role['user_role']['role_id'] == 1){

            echo '<a style="margin-left: 2%;" href="add/technician">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new technician</button></a> ';

          }
}
?>
<!-- SOMETHING STRANGE HERE -->
@if(count($rle)>0)
<div align="right">
          @if(auth()->user()->type == 'CLIENT')
          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
       @else
          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
@endif
</div>
@endif
<!-- Modal -->
@if($head == 'All HOS Details')
<?php $to = user::select('type')->distinct()->where('type','like','%HOS%')->get(); $v='hos'; ?>
@elseif($head == 'All Technicians Details')
<?php



if(($role['user_role']['role_id'] == 1)||(auth()->user()->type == 'Maintenance coordinator')) {


$techs= Technician::orderby('fname')->get();
} else{

$type=explode(",",auth()->user()->type);
$length=count($type);


   if($length==1){



    $techs= Technician::where('type', substr(strstr(auth()->user()->type, " "), 1))->orderBy('fname','ASC')->get();



}

else if($length==2){




$v1=$type[0];
$v2=$type[1];




if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();


}else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();


}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false) {
    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();


 }
else  if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();



}



}


else if($length==3){




$v1=$type[0];
$v2=$type[1];
$v3=$type[2];




if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();


}else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}

else  if(strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}
else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}
else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}
else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}
else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

}

}


else if($length==4){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];




if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}

else  if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {

$techs = Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

}




}

else if($length==5){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];
$v5=$type[4];




if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}
else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

$techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

    $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}

else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

   $techs= Technician::where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

}


}

}


$to = $techs; $v='technician';?>
@elseif($head == 'All Inspectors of work Details')
<?php $to = user::select('type')->distinct()->where('type','like','%Inspector%')->get(); $v = 'iow';?>
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('allpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <select name="name" class="form-control mr-sm-2">
                <option value="" selected="selected">select Name</option>
                <option value="">All <?php
                if($v == 'technician'){ echo 'Technicians';}
                if($v == 'iow'){ echo 'Inspectors of Works';}
                if($v == 'hos'){ echo 'Heads of Sections'; }

                     ?></option>
@foreach($rle as $tech)
<option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ $tech->type }}</option>
@endforeach
            </select>
      </div>
      </div>
  </div>

  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select name="type" class="form-control mr-sm-2">
                <option value='' selected="selected">Select Type/section</option>
                <option value="">All Type/Sections</option>


@foreach($to as $too)
<option value="{{ $too->type }}">{{ $too->type }}</option>
@endforeach
              </select>
          </div>
      </div>
      </div>

      <input type="text" name="change"
      value="<?php echo $v; ?>" hidden>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->

        <table class="table table-striped" id="myTable">
        <thead >
        <tr style="color: white;">
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th title="phone" scope="col">Phone</th>
            <th scope="col">@if($head == 'All Technicians Details') section @else  type @endif </th>

            @if($head == 'All Technicians Details')
            @if((substr($hotype,0,4) == 'HOS ')||($hotype == 'Maintenance coordinator')||($role['user_role']['role_id'] == 1))
               <th>Action</th>
            @endif
            @endif
        </tr>
        </thead>
        <tbody>
        <?php

        if (isset($_GET['page'])){
            if ($_GET['page']==1){

                $i=1;
            }else{
                $i = ($_GET['page']-1)*5+1; }
        }
        else {
            $i=1;
        }
        $i=1;

        ?>
        @foreach($rle as $tech)
            <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>{{ $tech->fname . ' ' . $tech->lname }}</td>
                <td>{{ $tech->email }}</td>
                <td>

      <?php $phonenumber = $tech->phone;
        if(substr($phonenumber,0,1) == '0'){

          $phonreplaced = ltrim($phonenumber,'0');
          echo '+255'.$phonreplaced;

        }else { echo $tech->phone;}

      ?></td>
       <td>
              <?php
               echo strtoupper($tech->type);  ?></td>
            @if($head == 'All Technicians Details')
            @if((substr($hotype,0,4) == 'HOS ')||($hotype == 'Maintenance coordinator')||($role['user_role']['role_id'] == 1))
               <td >
                <div class="row text-center" >
                    <a style="color: green;" href="{{ route('tech.edit.view', [$tech->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>

                    <form  method="POST" onsubmit="return confirm('Are you sure you want to delete this Technician?')" action="{{ route('tech.delete', $tech->id) }}" >
                        {{csrf_field()}}
                        <button type="submit" data-toggle="tooltip" title="Delete"> <a style="color: red;" href="" data-toggle="tooltip" ><i class="fas fa-trash-alt"></i></a></button>
                    </form>
                </div>
               </td>
               @endif
               @endif

            </tr>
        @endforeach
        </tbody>


        </table>
    </div>


    <script>
        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();
            $('#myTable').DataTable({
                "drawCallback": function ( settings ) {
                    /*show pager if only necessary
                     console.log(this.fnSettings());*/
                    if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
                        $('#dataTable_ListeUser_paginate').css("display", "block");
                    } else {
                        $('#dataTable_ListeUser_paginate').css("display", "none");
                    }

                }
            });


            jQuery('#myTable').DataTable({
                fnDrawCallback: function(oSettings) {
                    var totalPages = this.api().page.info().pages;
                    if(totalPages <= 1){
                        jQuery('.dataTables_paginate').hide();
                    }
                    else {
                        jQuery('.dataTables_paginate').show();
                    }
                }
            });
        });
    </script>
    @endSection
