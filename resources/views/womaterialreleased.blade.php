@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3><b>Materials accepted by Inspector of Works</b></h3>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
   
    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >HOS name</th>
				<th >Workorder Detail</th>
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity</th>
				
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['usermaterial']->fname.'  '.$item['usermaterial']->lname  }}</td>
                   
                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
					  <td>{{ $item->quantity }}</td>
                   
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endSection