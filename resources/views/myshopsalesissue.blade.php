@extends('layouts.master')

@section('title')
    Sales
    @endSection
@section('body')



   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <?php $id = Crypt::encrypt($idz); ?> 
              <li class="breadcrumb-item"><a href="{{route('addsales',[$id])}}">Add new sales</a></li>
              <li class="breadcrumb-item active">Sales</li>
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
                    <th>Price</th>
                    <th>Updated by</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                     <tbody>
                    <?php $i = 0; $summ = 0; ?>
                    @foreach($sales as $sl)
                       <?php   $summ += $sl->price;?>
                    <?php $i++; ?>
                           
                        <tr>
                            <td >{{ $i }}</td>
                            <td>{{ date('d F Y', strtotime($sl->date)) }}</td>
                          
                            
                              <td align="right">{{ number_format($sl->price) }} Tshs </td>
                               <td>{{ $sl['up']->name }}</td>
                          <td> <a style="color: green;" data-toggle="modal" data-target="#modal-sm"  title="Edit issue"><i
                                                    class="fas fa-edit"></i></a> </td>



   <!-- /.modal-dialog -->            
                            <div class="modal fade" id="modal-sm">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Edit used issue</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form method="POST">
                                  <div class="modal-body">
                                 
                                     <input required="" class="form-control form-control-lg" type="text" placeholder="Used  issue">
                                      <br>
                                     <input required="" class="form-control form-control-lg" type="number" placeholder="Price" min="0">
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

                        <tr><td colspan="2" align="center">Total</td><td align="right">{{$summ}} Tshs</td></tr>
                  
           
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
