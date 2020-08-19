<?php $status = \Illuminate\Support\Facades\Auth::user()->status;?>

@if(@$status == 0)
    <div class="alert alert-warning text-center">
        {{ __('text.new-registered-warning') }}
    </div>
@endif