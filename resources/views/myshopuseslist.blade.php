@extends('layouts.master')

@section('title')
    Used Issue
    @endSection
@section('body')


   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Used issues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                   <?php $id = Crypt::encrypt($idz); ?> 
              <li class="breadcrumb-item"><a href="{{url('adddairyissue',[$id])}}">Add new used issues</a></li>
              <li class="breadcrumb-item active">Used issues</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
        <hr>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
    


            <div class="card">
            
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Date</th>
                    <th>Used Issue</th>
                    <th>Used by</th>
                    <th>Price</th>
                    <th>Updated by</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                     <tbody>
                    <?php $i = 0; $summ = 0;?>
                    @foreach($usses as $house)
                     <?php   $summ += $house->price;?>

                        <?php $i++; ?>
                        <tr>
                            <td >{{ $i }}</td>
                            <td>{{ date('d F Y', strtotime($house->date)) }}</td>
                            <td>{{ $house->issue}}</td>
                            <td>{{$house['us']->name}}</td>
                            
                              <td align="right">{{ number_format($house->price) }} Tshs </td>
                            
                              <td>{{$house['up']->name}}</td>
                          <td> <a style="color: green;" data-toggle="modal" data-target="#modal-sm{{$i}}"  title="Edit issue"><i
                                                    class="fas fa-edit"></i></a> </td>
                    
   <!-- /.modal-dialog -->            
                            <div class="modal fade" id="modal-sm{{$i}}">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Edit Used Issue</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <?php $isssueid = Crypt::encrypt($house->id); ?> 
                                  <form method="POST" action="{{route('editusses',[$isssueid])}}">
                                    @csrf
                                  <div class="modal-body">
                                 
                                     <input required="" class="form-control form-control-lg" type="date" name="date" value="{{$house->date}}">
                                      <br>
                                     <input required="" class="form-control form-control-lg" type="text" placeholder="Used  issue" name="issue" value="{{ $house->issue}}">
                                      <br>

                                      <select style="color: black;" required class="custom-select" name="keeper" >
                                      <option value="{{ $house->keeper}}" selected>{{ $house['us']->name}}</option>
                                        @foreach($shopkeeper as $kp)
                                        <option value="{{$kp->id}}">{{$kp->name}}</option>
                                        @endforeach
                                      </select> 

                                    
                                      <br>
                                      <br>
                                     <input required="" class="form-control form-control-lg" type="number" placeholder="Price" min="0" value="{{$house->price}}" name="price">
                                      <br>
 
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                                  </form>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>

 <!-- /.modal-dialog -->
                    @endforeach
                     </tr>
                      
                    </tbody>
                      <tr><td colspan="4" align="center">Total</td><td align="right">{{number_format($summ)}} Tshs</td></tr>
           
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    </section>





     @endSection
