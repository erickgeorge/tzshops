@extends('layouts.master')

@section('title')
    Shops
    @endSection
@section('body')



   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ucfirst($shops->name)}} Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            
              <li class="breadcrumb-item"><a href="{{route('addshop')}}">Add new shop</a></li>
              <li class="breadcrumb-item active">Shop</li>
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
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                
                    <th>Name</th>
                    <th>Edit</th>
                  </tr>
                  </thead>
                     <tbody>
              
                        <tr>
                        
                            <td>{{$shops->name}}</td>

                          <td> <a style="color: green;" data-toggle="modal" data-target="#modal-sm"  title="Edit Name"><i
                                                    class="fas fa-edit"></i></a> </td>

          
                            <div class="modal fade" id="modal-sm">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Edit Shop Name</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                   <?php $shopid = Crypt::encrypt($shops->id); ?> 
                                  <form method="POST" action="{{route('editshop',[$shopid])}}">
                                    @csrf
                                  <div class="modal-body">
                                 
                                     <input required="" class="form-control form-control-lg" type="text" placeholder="Shop Name" value="{{$shops->name}}" name="shop">
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


              
                     </tr>
                       </tbody>

                       
                  
           
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

       <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
                     <?php $sum = 0; ?>
                     @foreach($sales as $sale)
                     <?php $sum += $sale->price?>
                     @endforeach  
                    <?php $sum1 = 0; ?>
                     @foreach($bought as $bt)
                     <?php $sum1 += $bt->price?>
                     @endforeach    
                     <?php $sum2 = 0; ?>
                     @foreach($used as $use)
                     <?php $sum2 += $use->price?>
                     @endforeach  
                      <?php $sum3 = 0; ?>
                     @foreach($voucher as $vc)
                     <?php $sum3 += $vc->value?>
                     @endforeach 
                      <?php $sum4 = 0; ?>
                     @foreach($transaction as $tra)
                     <?php $sum4 += $tra->price?>
                     @endforeach 
                      <?php $sum5 = 0; ?>
                     @foreach($added as $add)
                     <?php $sum5 += $add->price?>
                     @endforeach 

  
            <div class="card">
            
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                   
                    <th>Sales</th>

                    <th>{{number_format($sum)}} Tshs</th>

                  </tr>
                     <tr>
                   
                    <th>Boughts</th>
                  <th>{{number_format($sum1)}} Tshs</th>

                  </tr>
                     <tr>
                   
                    <th>Used</th>
                    <th>{{number_format($sum2)}} Tshs</th>

                  </tr>
                     <tr>
                   
                    <th>Voucher</th>
                    <th>{{number_format($sum3)}} Tshs</th>

                  </tr>

                   <tr>
                   
                    <th>Transaction</th>
                   <th>{{number_format($sum4)}} Tshs</th>

                  </tr>

                         <tr>
                   
                    <th>Amount Added</th>
                 <th>{{number_format($sum5)}} Tshs</th>

                  </tr>
                 
                 
           
                </table>
              </div>


               <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                   
                    <th>Available Amount</th>
                    <th>{{number_format($sum + $sum3 + $sum4 + $sum5 - $sum1 -$sum2)}} Tshs</th>

                  </tr>
             
                 
           
                </table>
              </div>
              <!-- /.card-body -->
            </div>
         
    <br><br>
    <h4 align="center">Over All Amount Used </h4>
    <hr>
              <div class="card">
            

              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
              
             @foreach($usses as $use)
                  <tr>
               
                    <th>{{$use['us']->name}}</th>
                    <th>{{number_format($use->price)}} Tshs</th>
               
                  </tr>
             @endforeach
                </table>
              </div>



              
              <!-- /.card-body -->
            </div>

           
          
   
    </section>





     @endSection
