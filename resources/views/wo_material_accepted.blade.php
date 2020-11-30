@extends('layouts.master')

@section('title')
    works orders
    @endSection

@section('body')

<div class="container">
    <br>
      @if(count($items) > 0)
    <div class="row container-fluid" >
        <div class="col-lg-12">
           <h5 style=" "  ><b  >Material(s) Accepted for This Works  Order </b></h5>
        </div>

     
@endif

        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
    <div style="margin-right: 2%; margin-left: 2%;">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif

    <div class="container">
        @if(count($items) > 0)

        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>

				<th >Item ID</th>
				<th >Description</th>
        <th >Unit of Measure</th>
				<th >Type</th>
				<th >Quantity</th>
				<th >Status</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>


                    <td>{{$item['material']->name }}</td>
                    <td>{{ ucwords(strtolower($item['material']->description)) }}</td>
                    <td>{{ ucwords(strtolower($item['material']->brand)) }}</td>
                    <td>{{ ucwords(strtolower($item['material']->type)) }}</td>
					          <td>{{ $item->quantity }}</td>
                      @if($item->status == 5)
                      <td><span >On Procurement Stage</span>
                       </td>
                       @elseif($item->status == 3)
                       <td><span >Sent From Store to HoS</span>
                       </td>
                       @elseif($item->status == 15)
                       <td><span> Purchased</span>
                       </td>
                        @elseif($item->status == 1012)
                       <td><span > Accepted by IoW</span>
                       </td>
                       @else
                        <td><span > Accepted by Director</span>
                       </td>

                       @endif
                    </tr>

                    @endforeach
            </tbody>
        </table>
    </div>

        @else

             <br><div> <h2 style="padding-top: 300px;">Currently no works order with accepted material</h2></div>


        @endif
    </div>
	</div>


    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });
    </script>
    @endSection
