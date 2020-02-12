@extends('layouts.master')

@section('title')
    Complaints
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-lg-12">
            <h3><b>Complaints </b></h3>
        </div>

        


       
    </div>
    <br>
    <hr class="container">
    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif

   
    <?php use App\Compliant;
            use App\User;

     ?>
    <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>WorkOrder</th>
          <th>Sender</th>
                    <th>Complaint</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                {{-- CREATE A CLASS WITH DEFINED W.O STASTUS FROM 1-7 THAT WILL CHECK HE STATUS NUMBER AND RETURN STATUS WORDS --}}
                <?php $i = 0;  ?>
                @foreach($compliant as $work)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                             <td><a href="{{ url('complian/'.$work->id) }}">{{ $work->work }}</a></td>
                            <td><?php $sender = user::where('id',$work->sender)->get();
                            foreach($sender as $send){echo $send->fname." ".$send->lname;} ?></td>
                            <td>{{ $work->message }}</td>

                            <td><?php $time = strtotime($work->created_at); echo date('d/m/Y',$time);  ?></td>
                            <td><a class="badge badge-info" href="{{ url('complian/'.$work->id) }}"><i class="fa fa-eye"></i>view</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 </div>

 @endsection