@extends('layouts.master')

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

     <h5 style="  text-transform: uppercase;" ><b style="text-transform: uppercase;">LIST OF AREAS ASSIGNED TO THIS COMPANY </b></h5>
              <hr>

                   <br><br>

                <table id="myTable" class="table table-striped">
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Area name</th>
                        <th scope="col">Assessment Month</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>



                    <tbody>
                  <?php $i = 0; ?>
                    @foreach($company as $comp)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $comp['areaname']->cleaning_name }}</td>
                            <td>{{ date('F Y', strtotime($comp->assessment_month ))}}</td>
                          @if($comp->status == 1)
                             <td><span class="badge badge-danger">No assessment form</span></td>
                             @elseif($comp->status == 2)
                             <td><span class="badge badge-primary">Crosscheck assessment form</span></td>
                             @elseif($comp->status == 3)
                             <td><span class="badge badge-warning">Assessment form submitted</span></td>
                             @elseif($comp->status == 4)
                             <td><span class="badge badge-primary">Assessment form approved by Head PPU</span></td>
                             @elseif($comp->status == 5)
                             <td><span class="badge badge-primary">Assessment form approved by Estate Director</span></td>
                             @elseif($comp->status == 6)
                             <td><span class="badge badge-primary">Payment Updated by Supervisor</span></td>
                             @elseif($comp->status == 7)
                             <td><span class="badge badge-danger">Closed</span></td>
                             @elseif($comp->status == 10)
                             <td><span class="badge badge-danger">Rejected by Head PPU</span></td>
                             @elseif($comp->status == 11)
                             <td><span class="badge badge-danger">Rejected by Estate Director</span></td>
                             @endif
                            <td><a style="color: green;"  href="{{route('track_company_assessment' , [$comp->id])}}" data-toggle="tooltip" title="View details"><i
                                                    class="fas fa-eye"></i></a></td>
                         
                           
                        </tr>
                    @endforeach
                    </tbody>
                    
                </table>


          

    @endSection