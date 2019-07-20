@extends('admin.layout.app')
@section('contents')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            @if(Request::segment(2)=='dashboard')
            <a href="{{route('dashboard')}}">Dashboard</a>
            @else
            <a href="{{route('lists-booking',['action'=>'all'])}}">Booking Room</a>
            @endif
        </li>
        <li class="breadcrumb-item active">Lists</li>
    </ol>
    <!-- Icon Cards-->
    <div class="row">      
        
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5">{{count($today)}} Meeting Today</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{route('lists-booking',['action'=>'today'])}}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5">{{count($pedding)}} Pedding Meeting</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{route('lists-booking',['action'=>'pedding'])}}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-life-ring"></i>
                    </div>
                    <div class="mr-5">{{count($active)}} All Meeting</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{route('lists-booking',['action'=>'active'])}}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
               
    </div>
    
@endsection