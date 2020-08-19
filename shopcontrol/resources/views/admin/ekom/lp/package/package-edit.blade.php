@extends('admin.layouts.master')
@section('content')

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin/')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/lp/package-list')}}">Package List</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Package Edit</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title">Package Edit
            <small></small>
        </h1>
        <!-- END PAGE TITLE-->

        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="clearfix plx__portlet-header">
                    <a href="#addLocation" class="pull-right" data-toggle="modal">Add New Location</a>
                    <h3 class="plx_portlet-title">Package Name</h3>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Package Name" value="Name of package">
                </div>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="clearfix plx__portlet-header">
                    <a href="#addLocation" class="pull-right" data-toggle="modal">Add New Location</a>
                    <h3 class="plx_portlet-title">Location</h3>
                </div>

                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-light">
                        <tr>
                            <td>Dhaka</td>
                            <td width="20"><a href="#" class="btn btn-sm btn-link"><i class="fa fa-close"></i></a></td>
                        </tr>
                        <tr>
                            <td>Gazipur</td>
                            <td width="20"><a href="#" class="btn btn-sm btn-link"><i class="fa fa-close"></i></a></td>
                        </tr>
                        <tr>
                            <td>Narayanganj</td>
                            <td width="20"><a href="#" class="btn btn-sm btn-link"><i class="fa fa-close"></i></a></td>
                        </tr>
                        <tr>
                            <td>Munshiganj</td>
                            <td width="20"><a href="#" class="btn btn-sm btn-link"><i class="fa fa-close"></i></a></td>
                        </tr>
                        <tr>
                            <td>Mymensingh</td>
                            <td width="20"><a href="#" class="btn btn-sm btn-link"><i class="fa fa-close"></i></a></td>
                        </tr>
                    </table>
                </div>

                <div class="modal fade" id="addLocation" tabindex="-1" role="addLocation" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="#" class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add Location</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="search" class="form-control" placeholder="Search">
                                </div>
                                <hr>
                                <div  class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                                    <ul class="tree">
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Dhaka</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Uttara</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Gulsan</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Badda</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhanmondi</label>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Gazipur</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhaka</label>
                                                    <ul>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Uttara</label>
                                                            <ul>
                                                                <li>
                                                                    <input type="checkbox">
                                                                    <label for="">Dhaka</label>
                                                                    <ul>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Uttara</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Gulsan</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Badda</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Dhanmondi</label>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Gulsan</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Badda</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Dhanmondi</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Narayanjang</label>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Dhaka</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Uttara</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Gulsan</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Badda</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhanmondi</label>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Gazipur</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhaka</label>
                                                    <ul>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Uttara</label>
                                                            <ul>
                                                                <li>
                                                                    <input type="checkbox">
                                                                    <label for="">Dhaka</label>
                                                                    <ul>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Uttara</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Gulsan</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Badda</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Dhanmondi</label>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Gulsan</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Badda</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Dhanmondi</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Narayanjang</label>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Dhaka</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Uttara</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Gulsan</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Badda</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhanmondi</label>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Gazipur</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhaka</label>
                                                    <ul>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Uttara</label>
                                                            <ul>
                                                                <li>
                                                                    <input type="checkbox">
                                                                    <label for="">Dhaka</label>
                                                                    <ul>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Uttara</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Gulsan</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Badda</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Dhanmondi</label>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Gulsan</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Badda</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Dhanmondi</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Narayanjang</label>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Dhaka</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Uttara</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Gulsan</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Badda</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhanmondi</label>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Gazipur</label>
                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <label for="">Dhaka</label>
                                                    <ul>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Uttara</label>
                                                            <ul>
                                                                <li>
                                                                    <input type="checkbox">
                                                                    <label for="">Dhaka</label>
                                                                    <ul>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Uttara</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Gulsan</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Badda</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox">
                                                                            <label for="">Dhanmondi</label>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Gulsan</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Badda</label>
                                                        </li>
                                                        <li>
                                                            <input type="checkbox">
                                                            <label for="">Dhanmondi</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">
                                            <label for="">Narayanjang</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn green">Done</button>
                            </div>
                        </form>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="clearfix plx__portlet-header">
                    <a href="#addRate" class="pull-right"  data-toggle="modal">Add New Rate</a>
                    <h3 class="plx_portlet-title">Weight based rates</h3>
                </div>

                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-light">
                        <thead>
                        <tr>
                            <th>Range</th>
                            <th>Rate Amount</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>0kg - 10kg</td>
                            <td>TK 20</td>
                            <td class="text-right">
                                <a href="#edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                <a href="#remove" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>11kg - 20kg</td>
                            <td>TK 20</td>
                            <td class="text-right">
                                <a href="#edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                <a href="#remove" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>21kg - 30kg</td>
                            <td>TK 20</td>
                            <td class="text-right">
                                <a href="#edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                <a href="#remove" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>31kg - 40kg</td>
                            <td>TK 20</td>
                            <td class="text-right">
                                <a href="#edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                <a href="#remove" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="addRate" tabindex="-1" role="addRate" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="#" class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add price based weight</h4>
                            </div>
                            <div class="modal-body">
                                <strong class="margin-bottom-10" style="display: block">RANGE</strong>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Minimum order weight</label>
                                            <input type="number" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Max order weight</label>
                                            <input type="number" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-12 margin-bottom-15">
                                        Your default package weighs 0.41 KG. This will count towards the total weight of an order.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""><strong>Rate amount</strong></label>
                                            <input type="number" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn green">Done</button>
                            </div>
                        </form>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
		
        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="{{url('admin/lp/package-list')}}" class="btn btn-default">Cancel</a>
                    </div>
                    <div class="col-xs-6 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
		
    </div>

@endsection