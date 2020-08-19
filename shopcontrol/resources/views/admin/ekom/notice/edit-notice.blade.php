@extends('admin.layouts.master')
@section('content')


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{@$notice_info->id?__('_ecom__text.edit-notice'):__('_ecom__text.add-new-notice')}}</span>
            </li>
        </ul>
    </div>



    <h1 class="page-title">
        {{@$notice_info->id?__('_ecom__text.edit-notice'):__('_ecom__text.add-new-notice')}}
        <small></small>
    </h1>


    <div class="container-alt margin-top-20">

        <div class="portlet light bordered">
            <div class="portlet-body">

                @if(@$notice_info)
                    <?php $url = url("admin/notice/$notice_info->id");?>
                @else
                    <?php $url = url("admin/notice");?>
                @endif

                <form class="row" method="post" action="{{$url}}">
                    {{csrf_field()}}
                    <input type="hidden" name="notice_id" id="notice_id" value="{{@$notice_info->id}}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.notice-message')}}
                            </label>
                            <textarea class="form-control" id="notice_message" name="notice_message"
                                      row="10">{!! old('notice_message')?old('notice_message'):@$notice_info->notice_message !!}</textarea>
                            <span class="required">
                                <strong>{{ $errors->first('notice_message') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 text-left">
                        <button type="submit" class="btn green" id="submit_form">
                            {{@$notice_info?__('_ecom__text.update'):__('_ecom__text.save')}}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

    <script>

        $(document).ready(function () {
            $('#notice_message').summernote({
                height: 100,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['Font Style', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['height', ['height']],
                    ['Insert', ['link']]
                ]
            });
        });
    </script>

@endsection