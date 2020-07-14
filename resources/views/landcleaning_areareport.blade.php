<div style="margin-top: 20px" align="center">
   
    <p><h2>University of Dar es salaam</h2>
     <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">  <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>

<p style="text-transform: uppercase; text-align: center;"><B><u> CLEANING AREAS </u></B>
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
  

            <table id="myTable" id="myTable" class="table table-striped">
                   <thead style="background-color: #376ad3;">
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Area Name</th>
                        <th scope="col">Zone Name</th>
                  
                    </tr>
                    </thead>



                    <tbody>
                  <?php $i = 0; ?>
                    @foreach($cleanarea as $clean_area)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            
                            <td>{{ $clean_area->cleaning_name }}</td>
                            <td>{{ $clean_area['zone']->zonename }}</td>




                            
                                               
                        </tr>
                    @endforeach
                    </tbody>
                    
                </table>



</div>








      
   </body>



             


<div id='footer'>
    <p class="page">page</p>
</div>   