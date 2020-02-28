@extends('layouts.master')

@section('title')
IoW Zones
@endSection

@section('body')


<div class="container" >


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
         <br>
         @foreach($zone as $zonename)
         @endforeach
                <h5>List of Inspector of Work in  {{ $zonename->zone }} </h5>

            <hr class="container">

                <a href="{{ route('iowwith.zone' , $zonename->zone)}}" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary"><i class="fa fa-file-pdf"></i> PDF</a>

               
                <table id="myTablee" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th> 
                        <th scope="col">Inspector of Work</th>
                        <th scope="col">Location</th>
                    </tr>
                    </thead>
                    <tbody>

                        
                    <?php $i = 0; ?>
                    @foreach($zone as $iow)
                        <?php $i++; ?>
                        <tr>
                            <td scope="row">{{ $i }}</td>
                            <td>
                              {{ $iow->fname.' '.$iow->lname }}
                            </td>

                            <td><a class="btn btn-primary" href="{{route('view.location', [$iow->id])}}" >view</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                

       

 </div>





           

                      <script>
        window.onload = function () {
            //write your function code here.

            document.getElementById("modal").click();
        };

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();


        });

    </script>

@endSection