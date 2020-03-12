@extends('layouts.master')

@section('title')
    Material Reserved
    @endSection

@section('body')


  



 @if(count($items) > 0)

    <br>



    <div>
        <div>
            <h3 align="center"><b>Material Purchased by Head of Procurement </b></h3>

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
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
   
    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>
                
                <th >Material Name</th>
                <th >Material Description</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                <th>Quntity Requested</th>
                <th>Quantity Reserved</th>
                <th >Quantity Purchased</th>
                 <th >Quantity Added </th>
                <th>Action</th>
               
    
                
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   <!-- <td>{{ $item['staff']->fname.' '.$item['staff']->lname }}</td>-->
                    <td>{{ $item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->reserved_material}}</td>
                 
                   <td style="color: blue" > {{ $item->quantity - $item->reserved_material}}</td>
                   <td>{{ $item->newstock }}</td>
                    <td>
                   @if($item->newstock == ($item->quantity - $item->reserved_material))
                      <a style="color: green;"  href="{{ route('store.material.afterpurchase', [$item->id]) }}" data-toggle="tooltip" title="Send to Head of Section"><i class="far fa-check-circle"></i></a>
                 
                        
                           @elseif($item->currentaddedmat == 1)
                            <a style="color: green;"
                                       onclick="myfunc1( '{{ $item->id}}','{{ $item->reserved_material}}','{{ $item->newstock }}' , '{{$item['material']->description}}' )"
                                       data-toggle="modal" data-target="#exampleModali" title="Increment Material"><i
                                                class="fas fa-plus"></i></a>
                                                @else
                                                 <a style="color: green;"
                                       onclick="myfunc( '{{ $item->id}}','{{ $item->reserved_material}}','{{ $item->newstock }}' , '{{$item['material']->description}}' )"
                                       data-toggle="modal" data-target="#exampleModal2" title="Increment Material"><i
                                                class="fas fa-plus"></i></a>
                                                @endif


                      
                         </td>

                    </tr>
                    @endforeach
            </tbody>
        </table>

       
         <h4  style="     color: #c9a8a5;"> Please add material in Store and assign Good Receiving Note for received material.</h4>
         <a class="btn btn-primary btn-sm"  href="grnpdf/{{$item->work_order_id}}" role="button">Assign GRN</a>
       
                  
    </div>

    


    

         <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="width:  400px; background-color: white" role="document">
         <div class="modal-content">

                    <button  class="close" data-dismiss="modal" aria-label="Close" style="padding-left:350px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                    <div class="modal-header ">
                     <div>
                        <h5  style="width: 360px;" align="center" ><b>Add Material in Store.</b></h5>
                        <hr  >
                    </div>  
                  </div>
                <div  style="width: 200px; display: inline-block;
                                            min-height: 50px;
 
                      height: auto; padding-left: 100px;">

                 
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


                   

                      <form method="POST" action="edit/Material/{{ $item->id}}" >
                        @csrf
                  
            <label style="width: 777px;" >Material Description </label>           
          <div class="input-group mb-3">  
                <input style="width: 565px;"  disabled style="color: black" required type="text" maxlength="35" class="form-control" id="description"
                       aria-describedby="emailHelp" name="description"  >
          </div>

            <div>
            <label style="width: 777px;" >Current Reserved Material </label>

            <div class="input-group mb-3">   
                <input style="width: 565px;" disabled style="color: black" required type="number" min="1"  class="form-control"
                       id="stock" > 
                       <input hidden id="istock" name="istock">    
            </div>
            </div>

            <div>
             <label style="width: 777px;" >Add Material in Quantity</label>    
            <div class="input-group mb-3">   
                <input style="width: 565px;" oninput="totalitem()" style="color: black" required type="number" min="1"  class="form-control"
                       aria-describedby="emailHelp" id="kstock"  placeholder="Add Material in Quantity" >        
            </div>
            </div>

            <div>
             <label style="width: 777px; "   ><b style="color: black;">Tottal Material requested</b></label>
               
             <div class="input-group mb-3">
                
                <input  style="width: 565px;"  required type="number"  class="form-control" id="tstock"
                        name="tstock" placeholder="Total Material requested">

              </div>
              </div>


              
        
                                                    <div style="padding-left: 120px;"> 
                                                       <button style=" width: 100px;" type="submit" class="btn btn-primary">Save
                                                       </button>
                                                    </div>
                                         
                                            </form>


                </div>


           
                  
                                                       <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 
    
     <script type="text/javascript">

          function myfunc1( U , V , W , X  ) {


            
            document.getElementById("istock").value = U;

            document.getElementById("stock").value = V;

            document.getElementById("tstock").value = W;


            document.getElementById("description").value = X;
            
       }
     </script>

    <script>

    function totalitem() {
         var x = document.getElementById("kstock").value;
         var y = document.getElementById("stock").value;
         var z  = parseInt(x) + parseInt(y);
         document.getElementById("tstock").value=z;
         document.getElementById("tstock").innerHTML = z;
     }


   </script>


     <script type="text/javascript">

      $("#materialedit").select2({
            placeholder: "Choose materia..",
            allowClear: true
        });
     </script>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>



<!-- modal2 -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="width:  400px; background-color: white" role="document">
         <div class="modal-content">

                    <button  class="close" data-dismiss="modal" aria-label="Close" style="padding-left:350px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                    <div class="modal-header ">
                     <div>
                        <h5  style="width: 360px;" align="center" ><b>Add Material in Store.</b></h5>
                        <hr  >
                    </div>  
                  </div>
                <div  style="width: 200px; display: inline-block;
                                            min-height: 50px;
 
                      height: auto; padding-left: 100px;">

                 
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


                   

                      <form method="POST" action="edit2/Material/{{ $item->id}}" >
                        @csrf
           
         
              <label style="width: 777px;" >Material Description </label>           
          <div class="input-group mb-3">  
                <input style="width: 565px;"  disabled style="color: black" required type="text" maxlength="35" class="form-control" id="descriptiony"
                       aria-describedby="emailHelp" name="description"  >
          </div>

             <div>
            <label style="width: 777px;" >Current added material after <br> purchased </label>

            <div class="input-group mb-3">   
                <input style="width: 565px;" disabled style="color: black" required type="number" min="1"  class="form-control"
                       id="mstock"  >  
                       <input  hidden id="estock" name="estock">      
            </div>
            </div>

             <div>
             <label style="width: 777px;" >Add Material in Quantity</label>    
            <div class="input-group mb-3">   
                <input style="width: 565px;" oninput="totalitem2()" style="color: black" required type="number" min="1"  class="form-control"
                       aria-describedby="emailHelp" id="astock"  placeholder="Add Material in Quantity" >        
            </div>
            </div>
            
               <div>
             <label style="width: 777px; "   ><b style="color: black;">Tottal Material requested</b></label>
               
             <div class="input-group mb-3">
                
                <input  style="width: 565px;"  required type="number"  class="form-control" id="pstock"
                        name="pstock" placeholder="Total Material requested">

              </div>
              </div>
        
                                                    <div style="padding-left: 120px;"> 
                                                       <button style=" width: 100px;" type="submit" class="btn btn-primary">Save
                                                       </button>
                                                    </div>
                                         
                                            </form>


                </div>


           
                  
                                                       <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 
    
    


    <script type="text/javascript"> 
            

          function myfunc( U , V , W , X  ) {


            
            document.getElementById("estock").value = U;

            document.getElementById("stock").value = V;

            document.getElementById("mstock").value = W;


            document.getElementById("descriptiony").value = X;
            
       }

    </script>
    <script>

   function totalitem2() {
         var x = document.getElementById("mstock").value;
         var y = document.getElementById("astock").value;
         var z  = parseInt(x) + parseInt(y);
         document.getElementById("pstock").value=z;
         document.getElementById("pstock").innerHTML = z;
     }



   </script>


     <script type="text/javascript">

      $("#materialedit").select2({
            placeholder: "Choose materia..",
            allowClear: true
        });
     </script>

                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>




            


    @else
    <div align="center" style="padding-top: 250px;"> <h1>No Material Purchased Yet</h1></div>

    @endif
    
    @endSection