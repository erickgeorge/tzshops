@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 class="container" ><b>Works Order with Material(s) Purchased</b></h5>
        </div>
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

    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >No</th>

				<th >Works order ID</th>
				<th >HOS name</th>
				<th >Action</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>{{ $item['workorder']->woCode }}</td>

                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>


                      <td>  <a style="color: green;" href="work_order_material_purchased/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">
                      View Materials</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endSection
