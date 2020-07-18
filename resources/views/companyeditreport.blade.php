@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<div class="container">
<br>
@foreach($assessmmentcompany as $company)
@endforeach
<h5 style="text-transform: uppercase;"><b>MONTHLY REPORT FOR COMPANIES ASSESSED FOR {{ date('F Y', strtotime($company->assessment_month))}}</b></h5>
<hr>

<div class="container">
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
    @endif</div>


<?php 
    use App\User;
    use App\assessmentsheet;  
    use App\landassessmentactivityform; 
    use App\landcrosschecklandassessmentactivity;
    use App\company;
    
 ?>

  <button style="max-height: 40px; float:right;" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                 <i class="fa fa-file"></i> PDF
                </button>



                <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{route('print.month.report' , $company->assessment_month)}}">
             @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>
 
  <div class="modal-body">

        <div class="row">
          <div class="col">
              <select name="tender" class="form-control mr-sm-2">
                <option value='' selected="selected">Select tender number</option>

@foreach($assessmmentgrouptender as $tend)
               <option value="{{$tend->company}}">{{$tend->company}}</option>
 @endforeach
              </select>
          </div>
      </div>
      

      <br>    
        <div class="row">
          <div class="col">
              <select name="company" class="form-control mr-sm-2">
                <option value='' selected="selected">Select company name</option>
  @foreach($assessmmentgroupcompany as $company)
               <option value="{{$company->company_id}}"> <td >{{$company['companyname']['compantwo']->company_name}}</td></option>
     
 @endforeach
              </select>
          </div>
      </div>
      
      
      <br> 

             <div class="row">
          <div class="col">
              <select name="area" class="form-control mr-sm-2">
                <option value='' selected="selected">Select area name</option>
@foreach($assessmmentgrouparea as $area)
            
               <option value="{{$area->area_id}}"> <td >{{$area['areaname']->cleaning_name}}</td></option>
     
 @endforeach
              </select>
          </div>
      </div>
      <br>

                  <div class="row">
          <div class="col">
              <select name="sheet" class="form-control mr-sm-2">
                <option value='' selected="selected">Assessment sheet</option>

@foreach($assessmmentgroupsheets as $sheets)
               <option value="{{$sheets->assessment_name}}"> <td >{{$sheets->assessment_name}}</td></option>
     
 @endforeach
              </select>
          </div>
      </div>
      
      
      <br>     







      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>






          <table id="myTable" class="table table-striped">

            <thead>
              <tr style="color: white;">
                        <th scope="col">#</th>
                         <th scope="col">Tender Number</th>
                        <th scope="col">Company name</th>
                    
                        <th scope="col">Area assessed</th>
                       <th scope="col">Assessment sheet</th>  
                        <th scope="col">Scores(%)</th>
                         <th scope="col">Comment</th>
                           @if(auth()->user()->type == 'Supervisor Landscaping')
                        <th scope="col">Action</th>
                        @endif
            </tr>
          </thead>
              <tbody>


<?php $i = 0; $sum = 0; $summ2= 0; ?>
           
           @foreach($assessmmentcompanyname as $company)
           <?php $i++;   ?>
     <?php
   //   $companypayment = company::where('tender', $company->company)->first();
     
     $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
       $summ = 0; 
     ?>
     @if(count($crosscheckassessmmentactivity)>0)

  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php  $summ += $assesment->score; $summ2 += $assesment->score; ?>
  @endforeach
  
  <?php  ?>
 
     <tr>
     <td >{{$i}}</td>
     <td >{{$assesment->company}}</td>
     <td >{{$assesment['assessmentid']['compantwo']->company_name}}</td>
     <td >{{$assesment['cleaningarea']->cleaning_name}}</td>
     <td >{{$assesment->assessment_sheet}}</td>
     <td align="center"><b><?php echo $summ ?></b></td>
     <td>{{$assesment->comment}}</td>  
    
                               @if(auth()->user()->type == 'Supervisor Landscaping')
                           <td><b> &nbsp;&nbsp;
                                           <a style="color: green;"
                                       onclick="myfunc('{{ $assesment->id }}','{{ $assesment->comment }}')"
                                       data-toggle="modal" data-target="#payment"  title="Update comment"><i
                                                class="fas fa-pen"></i></a> </td>@endif

     </tr> 


 @endif
  
 @endforeach
   </tbody>
      <?php $erpnd = $summ2/count($assessmmentcompanyname);   ?>
               
                  
                    <tr><td align="center" colspan="5" >AVERAGE SCORE</td><td align="center"> <?php   echo number_format((float)$erpnd, 2, '.', '')  ?>% </td></tr>

    </table>

<br><br>

               

       @if(count($crosscheckassessmmentactivity)>0)

      @if(auth()->user()->type == 'Supervisor Landscaping')
     
      @if($company->status2 == NULL)
                <b style="padding-left: 800px;">Foward to DVC ADMIN <a href="{{route('foward.dvc.adimin' , $company->assessment_month)}}" 
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Foward to DVC ADMIN"><i class="fas fa-share" ></i></a> </b>  
                                           @elseif($company->status2 == 2)
                                            
      @endif 
      @endif


                                             @if($company->status2 == 2)
                                              <b>Approved and fowarded to DVC by landscaping Supervisor : {{$company['assessorname']->fname .'   '. $company['assessorname']->lname}} on:  {{ date('d F Y', strtotime($company->assessordate))}}  </b>
                                            
                                             @endif
                                      






         <!--modalpayment-->

             <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="width:  400px; background-color: white" role="document">
         <div class="modal-content">

                    <button  class="close" data-dismiss="modal" aria-label="Close" style="padding-left:350px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                    <div class="modal-header ">
                     
                        <h5  style="width: 360px;" align="center" ><b>ADD COMMENT</b></h5>
                        <hr  >
                    
                    </div>

                    <div class="modal-body"   >

                             <form method="POST" action="edit/comment/new" >
                             @csrf                   
                        
                        <textarea   id="edit_name" style="color: black" type="text" required class="form-control"   
                               name="comment" placeholder="Update Comment ..." required></textarea> 
                                 <input id="edit_id" name="edit_id" hidden>
                               <br>


                               <button type="submit" class="btn btn-primary">Save</button>
                             </form>
                   

                    </div>

                    <br>
            
                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>

    </div>

                
<script type="text/javascript">
    
        function myfunc(A, B) {

            document.getElementById("edit_id").value = A;

            document.getElementById("edit_name").value = B;

        
       }
</script>


                
@endif



@endsection


