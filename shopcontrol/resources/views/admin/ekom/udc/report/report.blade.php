@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Reports</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- END PAGE HEADER-->

    <div class="container-alt">
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Reports
            <small></small>
        </h1>
        <!-- END PAGE TITLE-->

        <div class="row">
            <div class="col-md-6 col-sm-6">
                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <h3 class="plx_portlet-title">Sales</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">Make business decisions by comparing sales across products, UDC & Location.</span>

                        <div class="row">
                            <div class="col-sm-6">
                                <strong class="profile-desc-text">Orders Last 30 Days</strong> <br>
                                <strong style="font-size: 2em;">253</strong>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-chart pull-right">
                                    <div class="sparkline-line"
                                         data-sparkline="[8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11, 10]"
                                         data-lineColor="#F36A5B"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light report-table">
                                <tr>
                                    <td>
                                        <a href="#">Sales by Month</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        150 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Sales by Year</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        15 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Sales by Product</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        20 Products
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Sales by Product SKU</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        20 Variations
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Sales by featured Product</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        10 Orders
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->

                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <h3 class="plx_portlet-title">Customers</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">Gain insights into who your customers are and how they interact with your business.</span>

                        <div class="row">
                            <div class="col-sm-6">
                                <strong class="profile-desc-text">Customer Last 30 Days</strong> <br>
                                <strong style="font-size: 2em;">253</strong>
                            </div>
                            <div class="col-sm-6">
                                <div class="stat-chart pull-right">
                                    <div class="sparkline-line"
                                         data-sparkline="[8, 9, 7, 12, 10, 8, 12, 10, 10, 11, 9]"
                                         data-lineColor="#F36A5B"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light report-table">
                                <tr>
                                    <td>
                                        <a href="#">Customers over time</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        525 Customers
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Customers by UDC</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        15 UDC
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Customers by Ecommerce Partners</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        6 EP
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Customers by District</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        4 Districts
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Customers by Product</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        58 Products
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Customers by Product SKU</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        10 Products
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Customers by Featured Products</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        25 Products
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->

                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <h3 class="plx_portlet-title">eCommerce Partners</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">Gain insights how customers are responding through ecommerce platforms.</span>

                        <div class="row">
                            <div class="col-sm-6">
                                <strong class="profile-desc-text">Orders Last 30 Days</strong> <br>
                                <strong style="font-size: 2em;">253</strong>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-chart pull-right">
                                    <div class="sparkline-line"
                                         data-sparkline="[8, 9, 7, 12, 10, 8, 12, 10, 10, 11, 9]"
                                         data-lineColor="#F36A5B"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light report-table">
                                <tr>
                                    <td>
                                        <a href="#">EP by purchases</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        105 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">EP by products delivery</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        15 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">EP by successful orders</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        20 Orders
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->
            </div>

            <div class="col-md-6 col-sm-6">
                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <h3 class="plx_portlet-title">Purchases</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">Make business decisions by comparing purchase decisions across products, UDC & Location.</span>

                        <div class="row">
                            <div class="col-sm-6">
                                <strong class="profile-desc-text">Orders Last 30 Days</strong> <br>
                                <strong style="font-size: 2em;">25</strong>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-chart pull-right">
                                    <div class="sparkline-line"
                                         data-sparkline="[8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11, 10]"
                                         data-lineColor="#F36A5B"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light report-table">
                                <tr>
                                    <td>
                                        <a href="#">Purchases by Month</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        150 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Purchases by Product</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        15 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Purchases by Product SKU</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        20 Products
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Purchases by UDC</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        20 Variations
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Purchases by District</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        10 Orders
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="#">Purchases by featured Product</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        10 Orders
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->

                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <h3 class="plx_portlet-title">Logistics</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">Gain insights how logistics companies are executing orders. <br>&nbsp;</span>

                        <div class="row">
                            <div class="col-sm-6">
                                <strong class="profile-desc-text">Orders Last 30 Days</strong> <br>
                                <strong style="font-size: 2em;">253</strong>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-chart pull-right">
                                    <div class="sparkline-line"
                                         data-sparkline="[8, 9, 10, 11, 10, 10, 12, 10, 10, 8, 10, 9, 13, 14]"
                                         data-lineColor="#F36A5B"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light report-table">
                                <tr>
                                    <td>
                                        <a href="#">Logistics by number</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        5 Companies
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Logistics by receiving products</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        90 products
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Logistics by delivery products</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        105 products
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Logistics by order completion</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        90 products
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->

                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <h3 class="plx_portlet-title">Finances</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">View your store's finances including sales, returns, payments, and more.</span>

                        <div class="row">
                            <div class="col-sm-6">
                                <strong class="profile-desc-text">Total sales of this month</strong> <br>
                                <strong style="font-size: 2em;">253</strong>
                            </div>
                            <div class="col-sm-6">
                                <div class="stat-chart pull-right">
                                    <div class="sparkline-line"
                                         data-sparkline="[8, 9, 10, 11, 10, 10, 12, 10, 10, 8, 10, 9, 13, 14]"
                                         data-lineColor="#F36A5B"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light report-table">
                                <tr>
                                    <td>
                                        <a href="#">Total sales</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        115 orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Total purchases</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        102 orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Returns</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        20 returns
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Payments</a>
                                    </td>
                                    <td width="150" class="text-right">
                                        107 Transactions
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->
            </div>
        </div>
    </div>
@endsection