@extends('layouts.land')

@section('title')
    Add company to assess
    @endSection
@section('body')


<div  class="container">
            <br>
              @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif



 <?php
    use App\User;
    use App\assessmentsheet;
    use App\landassessmentactivityform;
    use App\landassessmentbeforesignature;
    use App\landcrosschecklandassessmentactivity;
    use App\company;

 ?>



   @foreach($company as $companyiii)
   @endforeach

<div class="container">

  <div class="row container-fluid">
        <div class="col-lg-12">

            <h5 style="text-transform: capitalize; color: black;"><b>  Assessment Sheet Details</b></h5>
        </div>
    </div>
    <hr>

   <div class="row">
     <div class="col">


   <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Company name</label>
        </div>
        <input  required class="form-control" placeholder="{{$companyname['compantwo']->company_name}} "
               aria-describedby="emailHelp" disabled="disabled" >
    </div>

     </div>
     <div class="col">

   <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Assessment period</label>
        </div>

          <?php  $dnext = strtotime($companyiii->nextmonth); ?>
        <input style="color: black" type="text" required class="form-control" placeholder=" {{ date('d F Y', strtotime($companyiii->nextmonth))}} -  {{ date('d F Y', strtotime('+1 month', $dnext)) }} "
               aria-describedby="emailHelp" value="" disabled>
    </div>

     </div>



   </div>


 <br>
 <?php  $ii = 0; ?>
   @foreach($company as $companyiii)
   <?php $ii++; ?>

    <div class="row container-fluid">
        <div class="col-lg-12">

            <h5><b>Sheet No: {{$ii}}</b></h5><h5 align="center" style="text-transform: capitalize; color: black;"><b>  Sheet name: &nbsp; {{ $companyiii->sheet  }}</b></h5>
        </div>
    </div>
    <hr>





    <br>
     <div class="row">




    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Area name</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$companyiii['are_a']->cleaning_name }}"
               aria-describedby="emailHelp" value="" disabled>
    </div>

    </div>

    <br>

         <div class="row">






    </div>

     <?php
    $assessmentsheetview = assessmentsheet::where('name', $companyiii->sheet)->get();

    $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $companyiii->tender)->where('area', $companyiii['are_a']->cleaning_name)->where('assessment_sheet', $companyiii->sheet)->where('month',date('Y-m', strtotime($companyiii->nextmonth)))->get();

     $assessmmentactivity = landassessmentactivityform::where('companynew', $companyiii->tender)->where('area', $companyiii['are_a']->cleaning_name)->where('assessment_sheet',  $companyiii->sheet)->where('month',date('Y-m', strtotime($companyiii->nextmonth)))->get();

       $assessmmentsignature = landassessmentbeforesignature::where('companynew', $companyiii->tender)->where('area', $companyiii['are_a']->cleaning_name)->where('assessment_sheet',  $companyiii->sheet)->where('month',date('Y-m', strtotime($companyiii->nextmonth)))->get();
    ?>


    <table class="table table-striped">
      <tr>
         <thead style="color: white;">
        <th style="width:20px" >#</th>
        <th style="width:400px" >Activity</th>
        <th style="width:40px">Percentage(%)</th>
        <th style="width:110px">Score(%)</th>
        <th>Remark</th>
      </thead>
      </tr>

     <tbody>


       @if(count($assessmmentsignature) == 0)

  <?php $i=0; ?>
      @foreach($assessmentsheetview as $assess)
       <?php $i++; ?>

          <?php $cmp = Crypt::encrypt($companyiii->tender); ?>

    <form method="POST" action="{{ route('work.assessment.activity.landscaping', [$companyiii->id , $cmp ]) }}">
                    @csrf

        <TR>


            <input  name="assessment_sheet[]" value="{{$companyiii->sheet}}"  hidden >
              <input  name="area[]" value="{{$companyiii['are_a']->cleaning_name }}"  hidden >

              <input name="assessmment" value="{{ date('Y-m', strtotime($companyiii->nextmonth))}}" hidden></input>

              <input  name="activity[]" value="{{$assess->activity}}"  hidden >


             <td>{{$i}}</td>
             <TD><textarea  class="form-control" type="text"  placeholder="{{$assess->activity}}" value="{{$assess->activity}}"  disabled ></textarea>   </TD>

             <TD><input style=" text-align: center;" class="form-control" type="number"   name="percentage[]" placeholder="{{$assess->percentage}}" value="{{$assess->percentage}}" readonly="readonly"></TD>


            <TD><input style="text-align: center;" class="form-control" type="number" id="tstock"   name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" min="0" max="{{$assess->percentage}}"></TD>


           <TD><textarea   class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD>

        </TR>

    @endforeach
       </tbody>
         </table>





    @else



                  @if(count($assessmmentactivity) == 0)


   <?php $cmp = Crypt::encrypt($companyiii->tender); ?>
     <form method="POST" action="{{ route('croscheck.assessment.activity.landscaping.beforesignature', [$companyiii->id  , $companyiii->type , $cmp , $companyiii->datecontract , $companyiii->status , $companyiii->nextmonth ]) }}">
                    @csrf

     <input  name="mytender[]"  value="{{$companyiii->tender}}" hidden>
     <input  name="myarea[]"    value ="{{$companyiii->area}}"  hidden>
     <input  name="mysheet[]"   value ="{{$companyiii->sheet}}" hidden>

   <?php
   $summ = 0;
   $summm = 0;
   $i=0;
   ?>


  <tbody>
  @foreach($assessmmentsignature as $assesment)
   <?php  $i++;  $summ += $assesment->percentage;  $summm += $assesment->score;?>

  <tr>
      <input  name="assessment_sheet[]" value ="{{$companyiii->sheet}}" hidden="hidden">
       <!--<input name="areaid[]" value ="{{$companyiii->area}}" hidden="hidden">--->
      <input  name="area[]" value="{{$companyiii['are_a']->cleaning_name}}"  hidden >
      <input  name="assessmment" value="{{ date('Y-m', strtotime($companyiii->nextmonth))}}" hidden ></input>

      <input value="{{$assesment->activity}}"  name="activity[]"  hidden>

      <td>{{$i}}</td>
      <TD  ><textarea  class="form-control" type="text" placeholder="{{$assesment->activity}}" required="required" disabled ></textarea> </TD>

      <TD><input style="text-align: center;"    min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="{{$assesment->percentage}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{$assesment->percentage}}" required="required" readonly="readonly">    </TD>

      <TD><input style=" text-align: center;" class="form-control" type="number"  name="score[]" placeholder="{{$assesment->score}}" value="{{$assesment->score}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required" min="0" max="{{$assesment->percentage}}" ></TD>

      <TD><input style="height:50px;"  class="form-control" type="text" name="remark[]" placeholder="{{$assesment->remark}}" value="{{$assesment->remark}}" ></TD>



 </tr>

  @endforeach
   </tbody>

 <th><b>Tottal</b></th>
 <td></td>
  <td align="center" ><b><?php echo $summ ?>%</b></td>
  <td align="center"><b><?php echo $summm ?>%</b></td>



  </table>



    <br>
    <br>



                            @else



   <?php $cmp = Crypt::encrypt($companyiii->tender); ?>
     <form method="POST" action="{{ route('croscheck.assessment.activity.landscaping', [$companyiii->id  , $companyiii->type , $cmp , $companyiii->datecontract , $companyiii->status , $companyiii->nextmonth ]) }}">
                    @csrf

     <input  name="mytender[]"  value="{{$companyiii->tender}}" hidden>
     <input  name="myarea[]"    value ="{{$companyiii->area}}"  hidden>
     <input  name="mysheet[]"   value ="{{$companyiii->sheet}}" hidden>
      <input  name="payments[]" value="{{$companyiii->payment}}"  hidden >

   <?php
   $summ = 0;
   $summm = 0;
   $i=0;
   ?>


  <tbody>
  @foreach($assessmmentactivity as $assesment)
   <?php  $i++;  $summ += $assesment->percentage;  $summm += $assesment->score;?>

  <tr>
      <input  name="assessment_sheet[]" value ="{{$companyiii->sheet}}" hidden="hidden">
       <input name="areaid[]" value ="{{$companyiii->area}}" hidden="hidden">
      <input  name="area[]" value="{{$companyiii['are_a']->cleaning_name}}"  hidden >

      <input  name="assessmment" value="{{ date('Y-m', strtotime($companyiii->nextmonth))}}" hidden ></input>

      <input value="{{$assesment->activity}}"  name="activity[]"  hidden>

      <td>{{$i}}</td>
      <TD  ><textarea  class="form-control" type="text" placeholder="{{$assesment->activity}}" required="required" disabled ></textarea> </TD>

      <TD><input style="text-align: center;"    min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="{{$assesment->percentage}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{$assesment->percentage}}" required="required" readonly="readonly">    </TD>

      <TD><input style=" text-align: center;" class="form-control" type="number"  name="score[]" placeholder="{{$assesment->score}}" value="{{$assesment->score}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required" min="0" max="{{$assesment->percentage}}" readonly="readonly"></TD>

      <TD><input style="height:50px;"  class="form-control" type="text" name="remark[]" placeholder="{{$assesment->remark}}" value="{{$assesment->remark}}" readonly="readonly" ></TD>
 </tr>

  @endforeach
   </tbody>

 <th><b>Tottal</b></th>
 <td></td>
  <td align="center" ><b><?php echo $summ ?>%</b></td>
  <td align="center"><b><?php echo $summm ?>%</b></td>



  </table>



    <br>
    <br>



                            @endif




    @endif

<br>


  @endforeach


 @if(count($assessmmentactivity) > 0)

  @if($assesment->status != 1)

 <p align="center"><span class="badge badge-primary">Company supervisor is satisfied and signed the document.</span> </p>
  
  @endif





   @if($assesment->status != 1)
          <button id="bt" type="submit" class="btn btn-primary">Save</button>
   @endif  
   @endif   

     @if(count($assessmmentactivity) == 0)
     <button id="bt" type="submit" class="btn btn-primary">Save</button>
    

            <a href="{{route('cleaningcompany')}}" onclick="closeTab()"><button type="button"
                         class="btn btn-danger">Cancel</button></a>

 <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-warning">Scroll up</button></a>

     @endif

 @if(count($assessmmentactivity) > 0)

      @if($assesment->status2 == 2)

      <p style="color: blue;" align="center">Company Supervisor is satisfied with the scores given you can now forward to Estate Officer for the further processes.</p>
      <button id="bt" type="submit" class="btn btn-primary">Foward to Estate Officer</button>
    

            <a href="{{route('cleaningcompany')}}" onclick="closeTab()"><button type="button"
                         class="btn btn-danger">Cancel</button></a>

      <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-warning">Scroll up</button></a>
 
    @endif   
    @endif

<br>
   </form>


 @if(count($assessmmentactivity) > 0)

 @if($assesment->status2 == 1)
  <?php $cmp = Crypt::encrypt($assesment->companynew); ?>
         <form method="POST" onsubmit="return confirm('Are you sure company supervisor is already signed and satisfied with the scores given ?')" action="{{ route('supervisorsatisfied', [$assesment->assessment_id , $cmp , $assesment->assessment_sheet , $assesment->month ])}}" >
            @csrf

            <div class="form-group ">

               
                    <input type="checkbox" name="emergency"  required> <b style="color:blue;">Please click the checkbox and save if company supervisor is already signed the document and satisfied.</b>
            
            
            </div>

            <button type="submit" class="btn btn-primary">Save</button> <a href="{{route('cleaningcompany')}}" onclick="closeTab()"><button type="button"
                         class="btn btn-danger">Cancel</button></a>

            <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-warning">Scroll up</button></a>

          </form>


    @endif



 <?php $cmp = Crypt::encrypt($companyname->tender); ?>


      <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
                 <a style="color: white;" href="{{route('addassessmentpdfform', [$companyname->id, $cmp ])}}" title="Assessment sheet pdf"> Print for signature <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                </button>

@endif

<br>
<br>
<br>

    @endSection
