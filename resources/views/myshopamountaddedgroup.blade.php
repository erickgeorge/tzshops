@extends('layouts.master')
@section('title')
   Ammount Added
    @endSection
@section('body')



   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Amount Added</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                     <?php $id = Crypt::encrypt($idz); ?> 
              <li class="breadcrumb-item"><a href="{{route('addamount',[$id])}}">Add amount on shop</a></li>
              <li class="breadcrumb-item active">Amounts</li>
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
                 <table class="table table-responsive  table-striped" id="myTable" >
                  <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Month</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                     <tbody>
                    <?php $i = 0; $summ = 0; ?>
                    @foreach($ammounts as $am)
                       <?php   $summ += $am->price;?>
                    <?php $i++; ?>
                           
                        <tr>
                            <td >{{ $i }}</td>
                            <td>{{ $am->month }}</td>
                          
                            
                              <td align="right">{{ number_format($am->price) }} Tshs </td>

                          <?php $id = Crypt::encrypt($idz); ?> 
                          <td> <a style="color: green;" href="{{route('ammountadded',[$id , $am->month])}}"  title="View"><i
                                                    class="fas fa-eye"></i></a> </td>  



                    @endforeach
                     </tr>
                        </tbody>
                        <tr><td colspan="2" align="center">Total</td><td align="right">{{number_format($summ)}} Tshs</td></tr>
                 
           
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
