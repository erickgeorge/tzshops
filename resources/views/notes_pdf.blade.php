<h1> Report generated for all work orders</h1>




<table class="table table-striped display" id="myTable" >
 <thead class="thead-dark">
    
    <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>
                    <th>Created date</th>
                    <th>Location</th>
                    
        
    </tr>
 </thead>
 <tbody>

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
                                <td><span class="badge badge-warning">new</span></td>
                            @elseif($work->status == 1)
                                <td><span class="badge badge-success">accepted</span></td>
                
              @elseif($work->status == 2)
                                <td><span class="badge badge-success">CLOSED</span></td>
              @elseif($work->status == 3)
                                <td><span class="badge badge-info">technician assigned</span></td>
              @elseif($work->status == 4)
                                <td><span class="badge badge-info">transportation stage</span></td>
              @elseif($work->status == 5)
                              <td><span class="badge badge-info">pre-implementation</span></td>
              @elseif($work->status == 6)
                              <td><span class="badge badge-info">post=implementation</span></td>
              @elseif($work->status == 7)
                              <td><span class="badge badge-info">material requested</span></td>
              @else
                                <td><span class="badge badge-success">procurement stage</span></td>               
                            @endif
                            <td>{{ $work->created_at }}</td>
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}
                            @endif
                            <td>
                                @if(strpos(auth()->user()->type, "HOS") !== false)

                                    @if($work->status == -1)
                                        
                                    @else

                                       
                                    @endif
                                @else
                                    @if($work->status == -1)
                                      
                                    @else
                                     
                                    @endif
                                @endif

                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>
</table>