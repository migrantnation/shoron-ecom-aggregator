@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="plx__user-profile clearfix">
        <div class="left-part">
            <div class="profile-inner-block">
                <div class="profile-cover clearfix">
                    <div class="plx__user-avatar" style="background-image: url('{{url('public/admin_ui_assets')}}/global/img/profile_img.png');"></div>

                    <div class="profile-information">
                        <div class="profile-basic">
                            <div class="clearfix">
                                <h3 class="profile-name"><a href="#" target="_blank">Dummy Ecommerce Ltd.</a></h3>
                            </div>
                            <address class="p-address"><i class="fa fa-map-marker"></i>&nbsp; Shahjadpur, Gulshan, Dhaka - 1212</address>
                            <p class="meta-info">01XXXXXXXXX, <a href="mailto:info@example.com">info@example.com</a></p>
                        </div>

                        <div class="clearfix stc-blocks">
                            <div class="stc-block">
                                Total Lifetime Sale<br>
                                <span class="stc-no">325</span>
                            </div>
                            <div class="stc-block">
                                Total Orders<br>
                                <span class="stc-no">200</span>
                            </div>
                            <div class="stc-block">
                                Total Products<br>
                                <span class="stc-no">215</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="clearfix plx__portlet-header">
                            <a href="#" class="pull-right">View More</a>
                            <h3 class="plx_portlet-title">Orders</h3>
                        </div>

                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr class="uppercase">
                                    <th width="80"> Order ID </th>
                                    <th> Date </th>
                                    <th> Customer </th>
                                    <th class="text-center"> Payment Status </th>
                                    <th class="text-center"> Order Status </th>
                                    <th width="80" class="text-center"> Price </th>
                                </tr>
                                </thead>
                                <tr>
                                    <td><a href="#" class="primary-link">54231</a></td>
                                    <td> 04-07-2017 </td>
                                    <td><a href="#">Rahim Udding</a> </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-warning">Unpaid</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-success">New</span>
                                    </td>
                                    <td class="text-center"> TK 345 </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="primary-link">54231</a></td>
                                    <td> 04-07-2017 </td>
                                    <td><a href="#">Rahim Udding</a> </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-info">Paid</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-info">Shipping</span>
                                    </td>
                                    <td class="text-center"> TK 345 </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="primary-link">54231</a></td>
                                    <td> 04-07-2017 </td>
                                    <td><a href="#">Rahim Udding</a> </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-info">Paid</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-default">Completed</span>
                                    </td>
                                    <td class="text-center"> TK 345 </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="primary-link">54231</a></td>
                                    <td> 04-07-2017 </td>
                                    <td><a href="#">Rahim Udding</a> </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-info">Paid</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-info">Shipping</span>
                                    </td>
                                    <td class="text-center"> TK 345 </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="primary-link">54231</a></td>
                                    <td> 04-07-2017 </td>
                                    <td><a href="#">Rahim Udding</a> </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-info">Paid</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-sm label-default">Completed</span>
                                    </td>
                                    <td class="text-center"> TK 345 </td>
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
                            <a href="{{url("ep/report")}}" class="pull-right">Show More Details</a>
                            <h3 class="plx_portlet-title">Report</h3>
                        </div>

                        <span class="profile-desc-text margin-bottom-15" style="display: block;">Make business decisions by comparing sales across products, UDC &amp; Location.</span>

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
                                        <a href="#">Sales last month</a>
                                    </td>
                                    <td width="100" class="text-right">
                                        150 Orders
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Served last month</a>
                                    </td>
                                    <td width="100" class="text-right">
                                        20 Customers
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Revenues last month</a>
                                    </td>
                                    <td width="100" class="text-right">
                                        BDT 20,530
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">UDC orders last month</a>
                                    </td>
                                    <td width="100" class="text-right">
                                        5 UDC
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Featured products ordered last month</a>
                                    </td>
                                    <td width="100" class="text-right">
                                        10 Products
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET -->
            </div>
        </div>

        <div class="right-part">
            <div class="plx__widget">
                <h3 class="widget-title">Recent Activity</h3>

                <ul class="activity-list">
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                    <li>
                        <p class="act-text">Rahim published an article: <a href="#">The eyes have it</a>.</p>
                        <span class="act-time">03 Jul, 2017 21:45 PM</span>
                    </li>
                </ul>
                <a href="#">View all recent activity</a>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection