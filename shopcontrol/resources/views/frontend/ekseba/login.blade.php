@extends('frontend.partner.partner-master')

@section('content')
    <div class="e__panel">
        <div class="e__login-panel">

            <div class="e__panel-header">
                <h3 class="e__site-logo">_ecom_</h3>
            </div>

            <div class="e__panel-body">
                <h4 class="e__title">Sign in</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <?php
                    $message = session('message');
                ?>
                @if (@$message)
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{@$message}}</li>
                        </ul>
                    </div>
                @endif

                <form action="{{url('partner_login')}}" class="e__login-form" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        {{--<label for="uname">Username/Email</label>--}}
                        <input type="text" class="form-control" placeholder="Username or Email" name="email">
                    </div>
                    <div class="form-group">
                        {{--<label for="password">Password</label>--}}
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <div class="form-group clearfix">
                        <div class="row">
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="checkbox" style="margin: 7px 0 0;">--}}
                                    {{--<label><input type="checkbox" value="">Remember me</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-sm-12 text-center">
                                <button type="submit" class=" btn btn-primary">Sign in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="e__panel-footer">
                Copyright &copy; <?= date("Y"); ?>. _ecom_
            </div>
        </div>
    </div>
@endsection