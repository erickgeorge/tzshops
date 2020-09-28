<title>Assessment Details</title>
<div style="margin-top: 20px" align="center">



    <p><h2>University of Dar es salaam</h2>
      <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');"> <h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;"> Assessment Details</b></p>
</div><br>

<style>
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
.nameee{
    text-transform:uppercase;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>




                <table  class="table table-striped">
                    <thead style="background-color: #376ad3;">
                    <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Assessment Area</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Assessment Month</th>
                         <th scope="col">Type</th>
                        <th scope="col">Assessment Sheet</th>
                        <th scope="col">Status</th>

                    </tr>
                    </thead>
                    <tbody>


                    <?php $i = 0; ?>
                    @foreach($assessmmentcompany as $assesment)
                          <?php $i++; ?>
                         <tr>
                             <td>{{ $i }}</td>
                              <td>{{$assesment->company}}</td>
                             <td>{{$assesment['areaname']->cleaning_name}}</td>
                                <td>{{$assesment['companyname']['compantwo']->company_name}}</td>
                             <td>{{ date('F Y', strtotime($assesment->assessment_month))}}</td>
                              <td>{{$assesment->type}}</td>
                              <td>{{$assesment->assessment_name}}</td>
                                                                                   @if($assesment->status == 1)
                             <td><span class="badge badge-danger">No assessment form submitted yet</span></td>
                             @elseif($assesment->status == 2)
                             <td><span class="badge badge-primary">Crosscheck assessment form</span></td>
                             @elseif(($assesment->status == 3) and ($assesment->status5 == 1) )
                             <td><span class="badge badge-warning">Submitted to Estate Officer<br> for approval</span></td>
                             @elseif(($assesment->status == 3) and ($assesment->status5 == 2) )
                             <td><span class="badge badge-warning">Submitted to Dean of Student<br> for approval</span></td>
                             @elseif(($assesment->status == 3) and ($assesment->status5 == 3) )
                             <td><span class="badge badge-warning">Submitted to Principle/Dean/<br> Directorates Director for approval</span></td>
                             @elseif($assesment->status == 4)
                             <td><span class="badge badge-primary">Approved by Estate Officer , <br>fowarded to Estate director for approval</span></td>
                             @elseif($assesment->status == 5)
                             <td><span class="badge badge-primary">Approved by Estate Director , <br>fowarded to DVC Accountant</span></td>
                             @elseif($assesment->status == 6)
                             <td><span class="badge badge-primary">Submitted to Estate Officer <br>for approval</span></td>
                             @elseif($assesment->status == 7)
                             <td><span class="badge badge-danger">Closed</span></td>
                             @elseif($assesment->status == 10)
                             <td><span class="badge badge-danger">Rejected by Estate Officer</span></td>
                             @elseif($assesment->status == 11)
                             <td><span class="badge badge-danger">Rejected by Estate Director</span></td>
                             @elseif($assesment->status == 12)
                             <td><span class="badge badge-danger">Rejected</span></td>
                              @elseif($assesment->status == 30)
                             <td><span class="badge badge-danger">Rejected by Dean of Student </span></td>
                             @elseif($assesment->status == 13)
                             <td><span class="badge badge-primary">Approved by DVC Admin </span></td>
                             @elseif($assesment->status == 25)
                             <td><span class="badge badge-success">Company paid </span></td>
                             @endif
                               <?php $tender = Crypt::encrypt($assesment->company); ?>

                         </tr>

                      @endforeach
                    </tbody>
                </table>



                <div id='footer'>
                    <p class="page">Page-</p>
                </div>
