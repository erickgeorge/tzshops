@extends('layouts.master')

@section('title')
    Bought Issues
    @endSection
@section('body')


    <br>

   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bought issues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                        <?php $id = Crypt::encrypt($idz); ?> 
              <li class="breadcrumb-item"><a href="{{route('adddairyboughtissue',[$id])}}">Add new bought issue</a></li>
              <li class="breadcrumb-item active">Bought issues</li>
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
                    <th>Month</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                     <tbody>
                    <?php $i = 0;$summ = 0; ?>
                    @foreach($bought as $bout)
                           <?php   $summ += $bout->price;?>
                        <?php $i++; ?>
                        <tr>
                            <td >{{ $i }}</td>
                            <td>{{ $bout->month }}</td>

                              <td align="right">{{ number_format($bout->price) }} Tshs </td>
                          <?php $id = Crypt::encrypt($idz); ?> 
                          <td> <a style="color: green;" href="{{route('boughtissues',[$id , $bout->month])}}"  title="View"><i
                                                    class="fas fa-eye"></i></a> </td>

                        </tr>

              
                    @endforeach
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
