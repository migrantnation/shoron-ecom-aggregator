@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{ __('admin_text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Edit Mobile Bank Information</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <h3 class="margin-top-10 margin-bottom-15">Mobile Bank Information</h3>

        <div class="portlet light bordered">
            @if(session("message"))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> {{session("message")}}
                </div>
            @endif


            <div class="portlet-body">
                <form action="{{url('update-mobile-bank-information')}}" method="post">
                    {{csrf_field()}}
                    <input name="user_id" id="user_id" value="{{@$user_info->id}}" type="hidden">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Bkash </label>
                                <input type="text" class="form-control" name="bkash_number"
                                       minlength="11" maxlength="11" onkeypress='validate(event)'
                                       value="{{old('bkash_number')?old('bkash_number'):$user_info->bkash_number}}">
                                <span class="required">
                                    <small>eg: 0195xxxxxxx</small>
                                    <strong>{{ $errors->first('bkash_number') }}</strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="">Rocket</label>
                                <input type="text" class="form-control" name="rocket_number"
                                       minlength="11" maxlength="12" onkeypress='validate(event)'
                                       value="{{old('rocket_number')?old('rocket_number'):$user_info->rocket_number}}">
                                <span class="required">
                                    <small>eg: 0182xxxxxxx</small>
                                    <strong>{{ $errors->first('rocket_number') }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-actions text-left">
                        <a href="{{url('udc')}}" class="btn default">{{ __('admin_text.cancel') }}</a>
                        <button type="submit" class="btn blue">{{ __('_ecom__text.update') }}</button>
                    </div>
                </form>


                <script>

                    function validate(evt) {
                        var theEvent = evt || window.event;
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode( key );
                        var regex = /[0-9]|\./;
                        if( !regex.test(key) ) {
                            theEvent.returnValue = false;
                            if(theEvent.preventDefault) theEvent.preventDefault();
                        }
                    }

                </script>

            </div>
        </div>
    </div>
@endsection