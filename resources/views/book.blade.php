@extends('layout.app')
@section('contents')
    <section class="page-section room-booking">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Room Booking</h2>
            <!-- Icon Divider -->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div> 
        </div>

        <div class="col-lg-8 mx-auto">
                <div class="card-header booking-room-title">Login</div>
                <div class="card-body">
                    <form id="loginForm" action="" method="post">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="text" value="{{ old('username') }}" name="username" class="form-control" id="username"  placeholder="Username" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('username')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" id="password"  placeholder="Password" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('password')}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <label>Date</label> 
                                
                            </div>

                        </div><!--/row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="text" value="{{ old('username') }}" name="username" class="form-control" id="username"  placeholder="Username" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('username')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" id="password"  placeholder="Password" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('password')}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" id="password"  placeholder="Password" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('password')}}</span>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!--/row-->

                        <br>

                        <div class="form-group text-right">
                            <input class="btn-login" type="submit" value="Save">
                        </div>

                        
                        <div class="form-group">
                        <span class="text-danger">{{$errors->first('error')}}</span>
                        </div>
                    </form>
                </div>
            </div>

    </section>

    @section('script')
       <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
   
    @endsection
@endsection