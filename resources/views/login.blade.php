@extends('layout.app')
@section('contents')
    <section class="page-section cls-login">
            <div class="col-lg-4 mx-auto">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form id="loginForm" action="{{route('islogin')}}" method="post">
                        {!! csrf_field() !!}
                        <div class="control-group">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" value="{{ old('username') }}" name="username" class="form-control" id="username"  placeholder="Username" autocomplete="off">
                                <span class="text-danger">{{$errors->first('username')}}</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="password"  placeholder="Password" autocomplete="off">
                                <span class="text-danger">{{$errors->first('password')}}</span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <input class="btn-login" type="submit" value="Login">
                        </div>
                        
                        <div class="form-group">
                        <span class="text-danger">{{$errors->first('error')}}</span>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@section('scripts')
<script>
$(document).ready(function(){
    $("#username").focus();
});
</script>
@endsection
@endsection