@extends('layouts.land')

@section('title')
Companies
    @endSection

@section('body')
    <br>
   <?php use Carbon\Carbon;?>
   
<div class="container">
  

       <div >
               @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
              @endif
                  <h5 style="  text-transform: uppercase;" ><b style="text-transform: uppercase;">Available cleaning company  </b></h5>
                  <hr>
                     @if((auth()->user()->type == 'Supervisor Landscaping')||($role['user_role']['role_id'] == 1))
                   <div class="row"><div class="col">
                  <a href="{{ route('renew_company_contract') }}"
                   class="btn btn-primary" >Add new company</a> </div> @endif 
                   
                   </div><br>
    
                <table id="myTableee" id="myTable" class="table table-striped">
                      
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Monthly Payment</th>
                        
                        <th scope="col">Contract Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($cleangcompany as $house)
                        <?php $i++; ?>



                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['tendercompany']->company_name }}</td>
                            @if($house->status == 1)
                            <td><?php echo number_format($house->payment) ?> Tshs </td>
                            @else
                            <td> <span class="badge badge-warning"> Not yet Updated</span> </td>
                            @endif

                            

                            @if($house->status == 1)


                 <?php $date = Carbon::parse($house->datecontract);
                 $now = Carbon::parse($house->endcontract);
                 $diff = $date->diffInDays($now); ?>
                            
                 @if($diff >= 365)
     
                           <td><?php 
                            

                             $start_date = new DateTime();
                             $end_date = (new $start_date)->add(new DateInterval("P{$diff}D") );
                             $dd = date_diff($start_date,$end_date);
                             echo $dd->y." years ".$dd->m." months ".$dd->d." days"; ?></td>   



                         
                   @else

                           <td><?php 
                            

                             $start_date = new DateTime();
                             $end_date = (new $start_date)->add(new DateInterval("P{$diff}D") );
                             $dd = date_diff($start_date,$end_date);
                             echo $dd->m." months ".$dd->d." days"; ?></td>   



                           
                  @endif  





                            @else
                            <td> <span class="badge badge-warning"> Not yet Updated</span> </td>
                            @endif


                            @if($house->status == 1)

                             <?php $now1 =  Carbon::now();
               
                             $endcont = Carbon::parse($house->endcontract);?>


                      
                             @if($now1 > $endcont)
                           <td><span class="badge badge-danger">Contract expired </span></td>
                             @else
                           <td><span class="badge badge-success">Active Contract </span></td>
                             @endif



                            @else
                            <td> <span class="badge badge-primary"> New</span> </td>
                            @endif

                            @if($house->status == 1)



                           
                             @if($now1 > $endcont)
                           <td><span class="badge badge-danger"> Expired </span></td>
                             @else
                           <td><span class="badge badge-success">Active  </span></td>
                             @endif



                            @else
                                                   
                            <td> <div class="row">  &nbsp;&nbsp;&nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->tender }}','{{ $house['tendercompany']->company_name }}' )"
                                       data-toggle="modal" data-target="#editHouse" title="Edit"><i
                                                class="fas fa-edit"></i></a>                                  

                                      <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this company Completely? ')"
                                          action="{{ route('company.delete', [$house->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form> </div>

                                     </td>
                            @endif


                        </tr>    
                            
               
                        
                         
                          
                  
                
                    @endforeach
                    </tbody>
                    
                </table>
                <br>


                                              
                                             <b style=" float:right;" > Report <a href="{{route('landscapingcleaningcompanyreport')}}" 
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Print report"><i class="fas fa-file" ></i></a> </b>
                                         

            </div>
            



 <div class="modal fade" id="editHouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Cleaning Company</h5>
                </div>

                <form method="POST" action="edit/company" class="col-md-6">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Tender Number </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="tender" placeholder="Enter Company tender number">
                            <input id="edit_id" name="edit_id" hidden>
                        </div>


                        <!--<div class="form-group">
                            <label for="name_of_house">Company Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="company" placeholder="Enter Company Name">
                          
                        </div>-->

                         <div style="width:600px;">
                                                <div style="float: left; width: 130px"> 
                                                      
                                                        <button  type="submit" class="btn btn-primary">Save Changes
                                                        </button>
                  
                                                       
                                               </div>
                                               <div"> 
                                                     
                                                        
                                                  <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>
                                                     
                                                       </div>
                                            </div>
                                                </div>
                </form>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>  





  <div class="modal fade" id="viewarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 align="center" class="modal-title" id="exampleModalLabel">AREA ASSIGNED</h5>
                </div>

             
                    <div class="modal-body">

                    </div>
             


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


 


    <script>
        window.onload = function () {
            //write your function code here.

            document.getElementById("modal").click();
        };

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();     
                $('#myTable5').DataTable();                                            
 

        });


        function myfunc(A, B, C, D, E , F , G, H) {

            document.getElementById("edit_id").value = A;

            document.getElementById("edit_name").value = B;

           document.getElementById("edit_type").value = C;
           
        
       }




    </script>


     @endSection