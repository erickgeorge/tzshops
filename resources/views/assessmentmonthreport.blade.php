<div style="margin-top: 20px" align="center">
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>
    @foreach($assessmmentcompany as $company)
@endforeach
    <p><b><u style="text-transform: uppercase;" >ASSESSMENT REPORT ON  {{ date('F Y', strtotime($company->assessment_month))}} </u></b></p>
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

 
    <br>
 <table id="myTable" class="table table-striped">
                    <thead style="background-color: #376ad3;" >
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
                            @elseif(($comp->score > 10) )
                            <td>F </td>
                            @endif 


                   
                           
                        </tr>
                    @endforeach
                    </tbody>
                    
                </table>
<br>


      <p>Avarage scores for all of the companies assessed on {{ date('F Y', strtotime($company->assessment_month))}} is {{$sum/count($assessmmentcompany)}}% </p>
     
      <p>Comment:    <u>{{$company->comment}}</u></p>

       <p>Assessed by:    <u>{{$company['assessorname']->fname .'   '. $company['assessorname']->lname}}</u></p>


     
      
   </body>



             


<div id='footer'>
    <p class="page">page</p>
</div>   