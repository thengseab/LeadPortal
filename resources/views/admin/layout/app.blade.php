<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal System</title>
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">    
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sb-admin.css')}}">

    <!--//Datatable-->
    <link rel="stylesheet" href="{{asset('assets/css/datatables.min.css')}}">
    <!--//Select timepicker-->
    <link rel="stylesheet" href="{{asset('assets/css/timepicki.css')}}">   

    <!-- font awesome-->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">   
    <!--//Select option with search box-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
    <!--//Datepicker-->
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">   

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- modal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
</head>
<body id="page-top">
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="{{route('dashboard')}}">BOOKING MEETING ROOM</a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
   
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-12">
              
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="profile">{{ucfirst($username)}}</span> <img class="profile-pic" src="{{asset('uploads/profile.jpg')}}" alt="">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('logout')}}">Logout</a>                
            </div>
        </li>
    </ul>

</nav>

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item <?php echo (Request::segment(2)=='dashboard')? 'active':'';?>">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>        
        <li class="nav-item <?php echo (Request::segment(2)=='lists-booking')? 'active':'';?>">
            <a class="nav-link" href="{{route('lists-booking',['action'=>'all'])}}">
            <i class="fa fa-calendar" aria-hidden="true"></i>
                <span>Booking Room</span></a>
        </li>
    </ul>

    <div id="content-wrapper">
        <div class="container-fluid">
       
           @yield('contents')
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Booking Meeting Room <?php echo date("Y");?></span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/js/sb-admin.min.js')}}"></script>

<!--//Select option with search box-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<!--//Select timepicker-->
<script src="{{asset('assets/js/timepicki.js')}}"></script>
<!--//Datepicker-->

<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

@yield('scripts')
</body>
</html>