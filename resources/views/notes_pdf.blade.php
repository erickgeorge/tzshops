<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2> 
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');">


    <p><h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;"><?php
     echo $header;
     ?></b></p>
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

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:before { content: "Page " counter(page); } @page {margin:20px 30px 40px 50px;}
</style>
<table>
 <thead class="thead-dark" align="center">

    <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>

                    <th>Location</th>


    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($wo as $work)

                    @if($work->status !== 0)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-details">{{ $work->details }}</td>
                            <td>{{ $work->problem_type }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                  @if($work->status == -1)
                                <td><span class="badge badge-warning">new</span>
                                <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 1)
                                <td><span class="badge badge-success">Accepted</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 0)
                                <td><span class="badge badge-danger">Rejected</span></td>
                            @elseif($work->status == 2)
                                <td><span class="badge badge-success">Waiting response from client</span></td>

                            @elseif($work->status == 30)
                                <td><span class="badge badge-success">Completely Closed</span></td>
                            @elseif($work->status == 3)
                                <td><span class="badge badge-info">technician assigned for work</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                             @elseif($work->status == 70)
                                <td><span class="badge badge-info">technician assigned for inspection</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif

                            @elseif($work->status == 4)
                                <td><span class="badge badge-info">transportation stage</span>
                                 <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 5)
                              <td><span class="badge badge-info">pre-implementation</span></td>
                            @elseif($work->status == 6)
                              <td><span class="badge badge-info">post implementation</span></td>
                            @elseif($work->status == 7)

                              <td><span class="badge badge-info">material requested</span>
                                <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 40)

                              <td><span class="badge badge-info">Material Requested Approved Succesifully</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                           @elseif($work->status == 52)

                              <td><span class="badge badge-info">IoW is checking for Work Order</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                           @elseif($work->status == 53)

                              <td><span class="badge badge-danger">Work Order is not approved by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif

                          @elseif($work->status == 25)

                              <td><span class="badge badge-info">Work Order Succesifully approved by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                           @elseif($work->status == 8)
                                  @if(auth()->user()->type == 'CLIENT')
                              <td><span class="badge badge-warning">  Material requested on progress</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-danger">Emergency</span></td>
                                @endif
                                  @else
                              <td><span class="badge badge-info">procurement stage</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                              @endif
                            @elseif($work->status == 9)
                              <td><span class="badge badge-info">Closed Satisfied by Client</span></td>

                            @elseif($work->status == 18)
                              @if(auth()->user()->type != 'CLIENT')

                               <td><span class="badge badge-info">Please correct your material</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                               @else
                               <td><span class="badge badge-primary">  Material received from store!</span></td>
                                                             @endif

                             @elseif($work->status == 19)
                               @if(auth()->user()->type != 'CLIENT')
                              <td><span class="badge badge-info">Material missing in store also DES notified</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                              @else
                               <td><span class="badge badge-warning">  Material requested on progress please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-danger">Emergency</span></td>
                                @endif
                                                             @endif
                               @elseif($work->status == 15)
                                                            <td><span class="badge badge-info">Material Accepted by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif

                                @elseif($work->status == 55)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span class="badge badge-danger">Some of Material Rejected</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span class="badge badge-warning">Material on Check by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                             @endif

                                @elseif($work->status == 57)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span class="badge badge-primary">Material Requested Again</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span class="badge badge-warning">Material on Check by IoW and HoS</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                             @endif

                                @elseif($work->status == 16)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span class="badge badge-danger">Material rejected by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span class="badge badge-warning">  Material requested on progress please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                             @endif



                              @else
                                <td><span class="badge badge-danger">Closed NOT SATISFIED BY CLIENT</span></td>
                              @endif
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}
                            @else

                                {{ $work->location }}
                            @endif
                            </td>

                                @endif
                        </tr>
                        @endforeach
                </tbody>
</table>
<div id='footer'>
    <p class="page"></p>
</div>
