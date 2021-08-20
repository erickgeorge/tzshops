<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MY SHOP | @yield('title')</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ucfirst(auth()->user()->name)}} </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Change Password</a></li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a class="dropdown-item" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Log Out</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
              </li>
              <!-- End Level two -->
            </ul>
          </li>

      <!-- Notifications Dropdown Menu -->
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->


   <!--Models-->
      <?php  use App\shop;
             use App\user;
      
      ?>
   <!--Models-->



  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MY SHOP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    
      <!-- Sidebar Menu -->
      <nav class="mt-2">

@if(auth()->user()->type != 'shopkeeper')
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       
          <?php $shops = shop::where('user_id',auth()->user()->id)->get(); ?>
           @if(count($shops) == 0)
            <li class="nav-item">
              
              <a href="{{route('shopsadmin')}}" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                <p>Shop </p>
              </a>
            </li>
         
            @else
 
           <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Shops 
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('shops',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('shops',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>{{$sp->name}}</p>
                    </a>
                  </li>
                  @endforeach

             @endif


              <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Dairy Used Issues
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('allissuesgroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('allissuesgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Dairy Used Issues</p>
                    </a>
                  </li>
                  @endforeach

             @endif


                    <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Shop Keepers
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('shopkeeper',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('shopkeeper',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Shop Keepers</p>
                    </a>
                  </li>
                  @endforeach

             @endif


           
                    <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Bought Issues
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('boughtissuesgroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('boughtissuesgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Bought Issues</p>
                    </a>
                  </li>
                  @endforeach

             @endif


                 <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Sales
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('salesissuesgroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('salesissuesgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Sales</p>
                    </a>
                  </li>
                  @endforeach

             @endif




                 <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Amount Added
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('ammountaddedgroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('ammountaddedgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Amount Added</p>
                    </a>
                  </li>
                  @endforeach

             @endif


                 <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Transactions
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('transactionsgroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('transactionsgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Transactions</p>
                    </a>
                  </li>
                  @endforeach

             @endif




                 <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Voucher
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('vouchergroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('vouchergroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Voucher</p>
                    </a>
                  </li>
                  @endforeach

             @endif





                 <?php $shop = shop::where('user_id',auth()->user()->id)->get(); ?>
             @if(count($shop) != 1)
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Summary
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    @foreach($shop as $sp)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <?php $spid = Crypt::encrypt($sp->id); ?> 
                        <a href="{{route('summarygroup',[$spid])}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{$sp->name}}</p>
                        </a>
                      </li>
                    </ul>
                    @endforeach
                  </li>
             @else
                  @foreach($shop as $sp)
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($sp->id); ?> 
                    <a href="{{route('summarygroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Summary</p>
                    </a>
                  </li>
                  @endforeach

             @endif
               </ul>
       @endif

    @endif


      

     @if(auth()->user()->type == 'shopkeeper')
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       

              <?php $shop = auth()->user()->shop_id; ?>

                  
                   <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('shops',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Dashboard</p>
                    </a>
                  </li>


                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('allissuesgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Dairy Used Issues</p>
                    </a>
                  </li>
       
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('shopkeeper',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Shop Keepers</p>
                    </a>
                  </li>
                 <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('boughtissuesgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Bought Issues</p>
                    </a>
                  </li>
              
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('salesissuesgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Sales</p>
                    </a>
                  </li>
       


                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('ammountaddedgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Amount Added</p>
                    </a>
                  </li>
               
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('transactionsgroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Transactions</p>
                    </a>
                  </li>
             
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('vouchergroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Voucher</p>
                    </a>
                  </li>
              
                  
                  <li class="nav-item">
                      <?php $spid = Crypt::encrypt($shop); ?> 
                    <a href="{{route('summarygroup',[$spid])}}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Summary</p>
                    </a>
                  </li>
              
               </ul>

               @endif
            
        

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
   <div class="main">

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
        @yield('body')
   </div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>-->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->

<script type="text/javascript">
    $(function () {

       //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })


    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
     // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

</script>
<script>
  $(function () {
    /*
     * Flot Interactive Chart
     * -----------------------
     */
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    var data        = [],
        totalPoints = 100

    function getRandomData() {

      if (data.length > 0) {
        data = data.slice(1)
      }

      // Do a random walk
      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
            y    = prev + Math.random() * 10 - 5

        if (y < 0) {
          y = 0
        } else if (y > 100) {
          y = 100
        }

        data.push(y)
      }

      // Zip the generated y values with the x values
      var res = []
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]])
      }

      return res
    }

    var interactive_plot = $.plot('#interactive', [
        {
          data: getRandomData(),
        }
      ],
      {
        grid: {
          borderColor: '#f3f3f3',
          borderWidth: 1,
          tickColor: '#f3f3f3'
        },
        series: {
          color: '#3c8dbc',
          lines: {
            lineWidth: 2,
            show: true,
            fill: true,
          },
        },
        yaxis: {
          min: 0,
          max: 100,
          show: true
        },
        xaxis: {
          show: true
        }
      }
    )

    var updateInterval = 500 //Fetch data ever x milliseconds
    var realtime       = 'on' //If == to on then fetch data every x seconds. else stop fetching
    function update() {

      interactive_plot.setData([getRandomData()])

      // Since the axes don't change, we don't need to call plot.setupGrid()
      interactive_plot.draw()
      if (realtime === 'on') {
        setTimeout(update, updateInterval)
      }
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === 'on') {
      update()
    }
    //REALTIME TOGGLE
    $('#realtime .btn').click(function () {
      if ($(this).data('toggle') === 'on') {
        realtime = 'on'
      }
      else {
        realtime = 'off'
      }
      update()
    })
    /*
     * END INTERACTIVE CHART
     */


    /*
     * LINE CHART
     * ----------
     */
    //LINE randomly generated data

    var sin = [],
        cos = []
    for (var i = 0; i < 14; i += 0.5) {
      sin.push([i, Math.sin(i)])
      cos.push([i, Math.cos(i)])
    }
    var line_data1 = {
      data : sin,
      color: '#3c8dbc'
    }
    var line_data2 = {
      data : cos,
      color: '#00c0ef'
    }
    $.plot('#line-chart', [line_data1, line_data2], {
      grid  : {
        hoverable  : true,
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: ['#3c8dbc', '#f56954']
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
    $('#line-chart').bind('plothover', function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
          .css({
            top : item.pageY + 5,
            left: item.pageX + 5
          })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }

    })
    /* END LINE CHART */

    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */
    var areaData = [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6],
      [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9],
      [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]]
    $.plot('#area-chart', [areaData], {
      grid  : {
        borderWidth: 0
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color     : '#00c0ef',
        lines : {
          fill: true //Converts the line chart to area chart
        },
      },
      yaxis : {
        show: false
      },
      xaxis : {
        show: false
      }
    })

    /* END AREA CHART */

    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data : [[1,10], [2,8], [3,4], [4,13], [5,17], [6,9]],
      bars: { show: true }
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [[1,'January'], [2,'February'], [3,'March'], [4,'April'], [5,'May'], [6,'June']]
      }
    })
    /* END BAR CHART */

    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
      {
        label: 'Series2',
        data : 30,
        color: '#3c8dbc'
      },
      {
        label: 'Series3',
        data : 20,
        color: '#0073b7'
      },
      {
        label: 'Series4',
        data : 50,
        color: '#00c0ef'
      }
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })
    /*
     * END DONUT CHART
     */

  })

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
</script>
</body>
</html>
