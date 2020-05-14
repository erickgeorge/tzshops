@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<div class="container">
<br>
@foreach($assessmmentcompany as $company)
@endforeach
<h5 style="text-transform: uppercase;">UPDATE REPORT ACCORDING TO COMPANY ASSESSMENT ON {{ date('F Y', strtotime($company->assessment_month))}}</h5>
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



                <table id="myTable" class="table table-striped">
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Company name</th>
                        <th scope="col">Area assessed</th>
                        <th scope="col">Scores(%)</th>
                        <th scope="col">Grade</th>
                    </tr>
                    </thead>



                    <tbody>
                  <?php $i = 0; $sum = 0; ?>
                    @foreach($assessmmentcompany as $comp)
                        <?php $i++; $sum += $comp->score ?>

                        <tr>
                            <th scope="row">{{ $i }}</th>
                           
                            <td>{{ $comp['companyname']->company_name }}</td>
                            <td>{{$comp['areaname']->cleaning_name}}</td>
                            <td>{{$comp->score}}</td> 
                            @if($comp->score > 70)    
                            <td>A</td>
                            @elseif(($comp->score > 60) )
                            <td>B+</td>    
                            @elseif(($comp->score > 50) )
                            <td>B</td> 
                            @elseif(($comp->score > 40) )
                            <td>C</td>  
                            @elseif(($comp->score > 30) )
                            <td>D</td>   
                            @elseif(($comp->score > 20) )
                            <td>E</td> 
                            @elseif(($comp->score >= 0) )
                            <td>F </td>
                            @endif 

                        </tr>
                    @endforeach
                    </tbody>
                    
                </table>

                <?php $erpnd = $sum/count($assessmmentcompany);   ?> 

   @foreach($companygroup as $company)
    <p>Avarage scores for {{ $company['companyname']->company_name }} according to area assigned is  <?php   echo number_format((float)$company->erick/$company->pnd, 2, '.', '')  ?>% </p>
   @endforeach

  

    
     <p>Avarage scores for all of the companies assessed is


    <?php   echo number_format((float)$erpnd, 2, '.', '')  ?>% </p>
     
      <p>Comment:    <u>{{$company->comment}}</u></p>

      

        @if(auth()->user()->type == 'Supervisor Landscaping')
     
       @if($company->status2 == NULL)
       <b style="padding-left: 800px;">Add comment <a data-toggle="modal" data-target="#payment"
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Update payment"><i class="fas fa-edit"></i></a> </b>
                                           @elseif($company->status2 == 1)
                                                  <b style="padding-left: 800px;">Foward to DVC ADMIN <a href="{{route('foward.dvc.adimin' , $comp->assessment_month)}}" 
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Foward to DVC ADMIN"><i class="fas fa-share" ></i></a> </b>    
                                           @endif 
                                           @endif

                                            @if(auth()->user()->type == 'DVC Admin')
                                             @if($company->status2 == 2)
                                             <b style="padding-left: 800px;">Print report<a href="{{route('print.month.report' , $comp->assessment_month)}}" 
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Print report"><i class="fas fa-share" ></i></a> </b>
                                           @endif
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
                     
                        <h5  style="width: 360px;" align="center" ><b>MONTHLY ASSESSMENT COMMENT</b></h5>
                        <hr  >
                    
                    </div>

                    <div class="modal-body"   >

                             <form method="POST" action="{{route('update.comment' , $comp->assessment_month)}}">
                             @csrf                   
                        
                        <textarea style="color: black" type="text" required class="form-control"   maxlength = "30"  
                               name="comment" placeholder="Update Payment ..." required></textarea> 
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

                

                




@endsection


