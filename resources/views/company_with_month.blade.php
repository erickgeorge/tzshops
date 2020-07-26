@extends('layouts.land')

@section('title')
Cleaning company report
@endSection
@section('body')

     <div  class="container">
            <br>
              @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif

     <h5 style="text-transform: capitalize;" ><b style="text-transform: capitalize;">Months</b></h5>
              <hr>

                   <br>

                <table id="myTable" class="table table-striped">
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Assessment Month</th>

                        <th scope="col">Action</th>
                    </tr>
                    </thead>



                    <tbody>
                  <?php $i = 0; ?>
                    @foreach($company as $comp)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td>{{ date('F Y', strtotime($comp->assessment_month))}}</td>



                            <td>@if(auth()->user()->type == 'Supervisor Landscaping')<a style="color: green;"  href="{{route('edit_company_month' , [$comp->assessment_month])}}" data-toggle="tooltip" title="Edit report"><i
                                                    class="fas fa-edit"></i></a>@else <a style="color: green;"  href="{{route('edit_company_month' , [$comp->assessment_month])}}" data-toggle="tooltip" title="view report"><i
                                                    class="fas fa-eye"></i></a>  @endif &nbsp; <a style="color: green;"  href="{{route('view_company_month' , [$comp->assessment_month])}}" data-toggle="tooltip" title="View report in bar graph"><i
                                                   class="fa fa-bar-chart"></i></a></td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>






    @endSection
