<div style="margin-top: 20px" align="center">
   
    <p><h2>University of Dar es salaam</h2>
     <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">  <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>

<p style="text-transform: uppercase; text-align: center;"><B><u> CLEANING COMPANIES </u></B>
 </p>
</div>
<style>
    body { background-image:  url('/images/estatfegrn.jpg');

    /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

    }
   
   .box{
    width:710px;
    height: 130px;
     border: 2px solid #b0aca0;
   }




   .container-name div {
  display: inline-block;
  width: 400px;
  min-height: 50px;
 
  height: auto;
  }


     
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>
 

    
   <body>






<div class="container">







   <?php use Carbon\Carbon;?>
   
<div class="container">
  

    
    
                <table id="myTableee" id="myTable" class="table table-striped">
                      
                  <thead style="background-color: #376ad3;">
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Monthly Payment(Tshs)</th>
                        
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
                            <td  style="text-align: right"><?php echo number_format($house->payment) ?>  </td>
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
                                                   
                         
                                 <td> <span class="badge badge-primary"> New</span> </td>
                                     
                            @endif


                        </tr>    
                            
               
                        
                         
                          
                  
                
                    @endforeach
                    </tbody>
                    
                </table>



</div>








      
   </body>



             


<div id='footer'>
    <p class="page">page</p>
</div>   