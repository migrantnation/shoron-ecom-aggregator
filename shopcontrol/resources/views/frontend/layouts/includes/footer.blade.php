<?php
if (Auth::user()) {
    $status = \Illuminate\Support\Facades\Auth::user()->status;
    $popup_checked = \Illuminate\Support\Facades\Auth::user()->popup_checked;
}
?>
<!-- Modal -->
<div class="modal fade" id="notification_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body">
                {{ __('text.new-registered-warning') }}
            </div>
            <div class="modal-footer">

                @if(@$popup_checked == 0)
                    <a href="{{url('checked-popup')}}">
                        <button type="button" class="btn btn-primary">OK</button>
                    </a>
                @else
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @endif

            </div>
        </div>
    </div>
</div>

@if((@$status == 0 && @$popup_checked == 0))
    <script>
        $(window).load(function () {
            $('#notification_popup').modal('show');
        });
    </script>
@endif

<div class="copyright">
    <div class="container text-center">
        &copy; <?= date("Y"); ?> A2i a2i.com . All rights reserved. Our <a href="{{url('partners')}}">Partners</a>
    </div>
</div>