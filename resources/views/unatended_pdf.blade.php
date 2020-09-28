<title>unattended works order report</title>
<h1 style="text-align: center"> ESTATE </h1>
<h1 style="text-align: center" style="text-transform: uppercase;">unattended works order report</h1>
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
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>

<div  id="div_print" class="container" style="margin-right: 2%; margin-left: 2%;">
        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>
                    <th>Created date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>

                {{-- CREATE A CLASS WITH DEFINED W.O STASTUS FROM 1-7 THAT WILL CHECK THE STATUS NUMBER AND RETURN STATUS WORDS --}}
                <?php $i = 0;  ?>
                @foreach($wo as $work)


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
                                                            <td><span class="badge badge-info">post implementation</span></td>
                            @elseif($work->status == 7)
                                                            <td><span class="badge badge-info">material requested</span></td>
                            @else
                                <td><span class="badge badge-success">procurement stage</span></td>
                            @endif

                            <td><?php $time = strtotime($work->created_at); echo date('d/m/Y',$time);  ?></td>
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}
                            @endif
                            <td>

                                @if(strpos(auth()->user()->type, "HOS") !== false)

                                    @if($work->status == -1)
                                        <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>
                                    @elseif($work->status == 2)
                                         <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>

                                    @else
                                        <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                    @endif
                                @else
                                    @if($work->status == -1)
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                    @else
                                        {{--<a href="{{ route('workOrder.view', [$work->id]) }}" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>--}}
                                        &nbsp;
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>&nbsp;
                                    @endif


                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no work oder</h1>
        @endif
    </div>
    <div id='footer'>
        <p class="page">Page-</p>
    </div>
