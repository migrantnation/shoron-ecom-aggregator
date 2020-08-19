@extends('frontend.partner.partner-master')
@section('content')
    <div class="e__panel">
        <div class="e__panel-content">

            <div class="e__panel-header">
                <a href="{{url('logout')}}" class="pull-right">Logout</a>
                <h3 class="e__site-logo">partner</h3>
            </div>

            <form action="{{url('api/auth-check')}}" method="get" class="e__panel-body text-center">
                {{--{{csrf_field()}}--}}

                @if (session('message'))
                    <div class="alert alert-danger">
                        <ul>
                            {{session('message')}}
                        </ul>
                    </div>
                @endif

                <a href="#" class="btn btn-default">Service-1</a>
                <a href="#" class="btn btn-default">Service-2</a>
                <a href="#" class="btn btn-default">Service-3</a>
                <input type="hidden" value="{{$get_info->auth_token}}" name="auth_token">
                <a href="{{url("api/auth-check-test/$get_info->auth_token")}}" class="btn btn-primary btn-default" type="submit">Ek-Shop</a>
            </form>

            <div class="e__panel-footer">
                Copyright &copy; <?= date("Y"); ?>. partner
            </div>

        </div>
    </div>
@endsection