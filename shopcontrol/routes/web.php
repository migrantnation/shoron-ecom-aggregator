<?php
// ADMIN AUTH
Auth::routes();

Route::get(
    'admin/login', [
        'as' => 'ekom-login',
        'uses' => 'admin\AdminLoginController@showLoginForm'
    ]
);

Route::post(
    'admin/check-login', [
        'as' => 'check-ekom-login',
        'uses' => 'admin\AdminLoginController@login'
    ]
);

Route::get('api/auth-check', 'partnerController@go_to_ekom2');

Route::middleware(['adminAuth'])->group(function () {
    
    //LANGUAGE
    Route::get('admin/switch-language/{lang}', array(
        'Middleware' => 'LanguageSwitcher',
        'uses' => 'Frontend\EkomFrontController@switch_language'
    ));
    //E-kom Admin Auth
    Route::get('admin/profile', 'admin\ekom\EkomAdminController@profile');
    Route::post('admin/update-profile', 'admin\ekom\EkomAdminController@update_profile');
    Route::get('admin', 'admin\ekom\EkomAdminController@index');
    Route::post('admin/logout', 'admin\AdminLoginController@logout')->name('admin-logout');
    Route::get('admin/updatee_logout', 'admin\AdminLoginController@logout');

    Route::get('admin/mobile-bank-information/{user_id}', 'admin\ekom\EkomAdminController@mobile_bank_information');
    Route::post('admin/update-mobile-bank-information', 'admin\ekom\EkomAdminController@update_mobile_bank_information');

    Route::get('active-user-graph', 'admin\ekom\EkomAdminController@active_user_graph');
    Route::get('cancel-order-graph', 'admin\ekom\EkomAdminController@cancel_order_graph');
    Route::get('ep-statistics-graph', 'admin\ekom\EkomAdminController@ep_statistics_graph');
    Route::get('visitors', 'admin\ekom\EkomAdminController@visitors');
    Route::get('_ecom_-partners', 'admin\ekom\EkomAdminController@_ecom__partners');
    Route::get('top-users', 'admin\ekom\EkomAdminController@top_users');
    Route::get('sale-per-day', 'admin\ekom\EkomAdminController@sale_per_day');
    Route::get('transaction-per-day', 'admin\ekom\EkomAdminController@transaction_per_day');
    Route::get('order-per-entrepreneur-per-day', 'admin\ekom\EkomAdminController@order_per_entrepreneur_per_day');
    Route::get('average-delivery-time', 'admin\ekom\EkomAdminController@average_delivery_time');

    // Admin Demo
    Route::get('admin/demo', function () {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        //$data['reports_management'] = 'start active open';
        //$data['udc_overview'] = 'active';
        return view('admin.ekom.dashboard.dashboard')->with($data);
    });

    Route::get('admin/super-admin-list', 'admin\ekom\EkomAdminController@supperAdmin');
    Route::get('admin/super-admin/edit', 'admin\ekom\EkomAdminController@supperAdminEdit');
    Route::get('admin/super-admin/create', 'admin\ekom\EkomAdminController@supperAdminCreate');

    Route::get('admin/customer-support-list', 'admin\ekom\EkomAdminController@customerSupport');
    Route::get('admin/customer-support/create', 'admin\ekom\EkomAdminController@customerSupportCreate');
    Route::get('admin/customer-support/edit', 'admin\ekom\EkomAdminController@customerSupportEdit');

    Route::get('admin/accountant-list', 'admin\ekom\EkomAdminController@accountant');
    Route::get('admin/accountant/create', 'admin\ekom\EkomAdminController@accountantCreate');
    Route::get('admin/accountant/edit', 'admin\ekom\EkomAdminController@accountantEdit');
    Route::get('admin/accountant/edit', 'admin\ekom\EkomAdminController@accountantEdit');

    Route::get('admin/resolution-manager-list', 'admin\ekom\EkomAdminController@resolutionManager');
    Route::get('admin/resolution-manager/create', 'admin\ekom\EkomAdminController@resolutionManagerCreate');
    Route::get('admin/resolution-manager/edit', 'admin\ekom\EkomAdminController@resolutionManagerEdit');

    //UDC MANAGEMENT
    Route::get('admin/country-location', 'admin\LocationController@get_next_locations');
    Route::get('admin/udc', 'admin\ekom\UdcManagementController@index');
    Route::get('admin/udc/{user_id}/orders', 'admin\ekom\UdcManagementController@orders');
    Route::post('admin/udc/{user_id}/orders', 'admin\ekom\UdcManagementController@orders');
    Route::get('admin/udc/{user_id}/payments', 'admin\ekom\UdcManagementController@payments');
    Route::get('admin/udc/{user_id}/reports', 'admin\ekom\UdcManagementController@reports');
    Route::get('admin/udc/{user_id}/transactions', 'admin\ekom\UdcManagementController@all_udc_transactions');

    Route::get('admin/udc/payments', 'admin\ekom\UdcManagementController@all_udc_payments');
    Route::get('admin/udc/payments/details/{udc_id}', 'admin\ekom\UdcManagementController@paymentDetails');
    Route::get('admin/udc/reports', 'admin\ekom\UdcManagementController@all_udc_reports');
    Route::get('admin/udc/transactions', 'admin\ekom\UdcManagementController@all_udc_transactions');
    Route::get('admin/orders/_ecom_-orders', 'admin\ekom\EkomAdminController@_ecom__orders');
    Route::get('admin/orders/ep-orders', 'admin\ekom\EkomAdminController@_ecom__orders');
    Route::post('admin/orders/ep-orders', 'admin\ekom\EkomAdminController@_ecom__orders');

    Route::post('admin/orders/export-orders', 'admin\ekom\EkomAdminController@export_orders');

    //EP MANAGEMENT
    Route::get('admin/all-ep', 'admin\ekom\EkomEpController@index');
    Route::get('admin/add-ep', 'admin\ekom\EkomEpController@add_ep');
    Route::get('admin/ep/change-status/{epid}/{status}', 'admin\ekom\EkomEpController@change_status');
    Route::post('admin/store-ep', 'admin\ekom\EkomEpController@store_ep');
    Route::get('admin/edit-ep/{ep_id}', 'admin\ekom\EkomEpController@edit_ep');
    Route::post('admin/update-ep', 'admin\ekom\EkomEpController@update_ep');
    Route::get('admin/ep/{ep_id}/orders', 'admin\ekom\EkomEpController@orders');
    Route::post('admin/ep/{ep_id}/orders', 'admin\ekom\EkomEpController@orders');
    Route::get('admin/ep/payments', 'admin\ekom\EkomEpController@payments');
    Route::get('admin/ep/payments/details', 'admin\ekom\EkomEpController@paymentDetails');
    Route::get('admin/ep/reports', 'admin\ekom\EkomEpController@reports');

    //LP MANAGEMENT
    Route::get('admin/lp-list', 'admin\ekom\LogisticPartnerController@lp_list');
    Route::get('admin/lp/create', 'admin\ekom\LogisticPartnerController@lpCreate')->name('admin.lp.create');
    Route::post('admin/lp/store', 'admin\ekom\LogisticPartnerController@lpStore')->name('admin.lp.save');
    Route::get('admin/lp/edit/{id}', 'admin\ekom\LogisticPartnerController@edit')->name('admin.lp.edit');
    Route::post('admin/lp/update/{id}', 'admin\ekom\LogisticPartnerController@update')->name('admin.lp.update');
    Route::get('admin/lp/delete/{id}', 'admin\ekom\LogisticPartnerController@delete')->name('admin.lp.delete');
    Route::get('admin/lp/{id}/orders', 'admin\ekom\LogisticPartnerController@lpOrders')->name('admin.lp.orders');
    Route::post('admin/lp/{id}/orders', 'admin\ekom\LogisticPartnerController@lpOrders')->name('admin.lp.orders');
    Route::get('admin/lp/payments', 'admin\ekom\LogisticPartnerController@payments');
    Route::get('admin/lp/payments/details', 'admin\ekom\LogisticPartnerController@paymentDetails');
    Route::get('admin/lp/report', 'DummyController@lpReport');
    Route::get('admin/lp/change-status/{lpid}/{status}', 'admin\ekom\LogisticPartnerController@change_status');

    // LP PACKAGE MANAGEMENT
    Route::get('admin/lp/packages/{lp_id}', 'admin\ekom\LogisticPartnerController@lp_package_list');
    Route::post('admin/lp/save-package', 'admin\ekom\LogisticPartnerController@save_package');
    Route::post('admin/lp/change-package-status', 'admin\ekom\LogisticPartnerController@change_package_status');
    Route::post('admin/lp/package-location', 'admin\ekom\LogisticPartnerController@package_location');

    Route::get('admin/udc/order-details/{order_id}', 'admin\ekom\OrderManagementController@order_details');
    Route::post('admin/change-order-status', 'admin\ekom\OrderManagementController@change_order_status');
    Route::get('admin/ekom/oder-tracking/{order_id}', 'admin\ekom\OrderManagementController@oder_tracking');
    Route::get('admin/ekom/oder-tracking', 'admin\ekom\OrderManagementController@oder_tracking');
    //PAYMENTS
    Route::post('admin/make-payment', 'admin\udc\OrderManagementController@oder_tracking');
    Route::get('admin/payments/all-ep', 'admin\ekom\PaymentController@index');
    Route::get('admin/payments/ep-orders/{ep_id}', 'admin\ekom\PaymentController@ep_orders');
    Route::post('admin/payments/pay-to-ep', 'admin\ekom\PaymentController@pay_to_ep');
    Route::get('admin/payments/lp-orders', 'admin\ekom\PaymentController@lp_orders');
    Route::post('admin/payments/pay-to-lp', 'admin\ekom\PaymentController@pay_to_lp');

    //Report Management
    //Route::get('admin/reports/orders', 'admin\ekom\AdminReportController@order_overview');
    Route::get('admin/reports/orders/top-ten-active-orders', 'admin\ekom\AdminReportController@top_ten_active_orders');
    Route::get('admin/reports/orders/top-ten-delivered-orders', 'admin\ekom\AdminReportController@top_ten_delivered_orders');

    // New Routs (Made by Ilias)
    Route::get('admin/reports/orders', 'admin\ekom\AdminReportController@orders_report');
    Route::post('admin/reports/orders', 'admin\ekom\AdminReportController@orders_report');

    Route::get('admin/reports/sales', 'admin\ekom\AdminReportController@sales_report');
    Route::post('admin/reports/sales', 'admin\ekom\AdminReportController@sales_report');

    Route::get('admin/reports/commissions', 'admin\ekom\AdminReportController@commissions_report');
    Route::post('admin/reports/commissions', 'admin\ekom\AdminReportController@commissions_report');

    Route::get('admin/reports/kpi', 'admin\ekom\AdminReportController@kpi_report');
    Route::post('admin/reports/kpi', 'admin\ekom\AdminReportController@kpi_report');

    Route::get('admin/reports/udc', 'admin\ekom\AdminReportController@udc_overview');
    Route::get('admin/reports/udc-commission', 'admin\ekom\AdminReportController@udc_commission_report');
    Route::post('admin/reports/udc-commission', 'admin\ekom\AdminReportController@udc_commission_report');

    Route::post('admin/upload-image', 'FileProcessingController@upload_image');

    //UNLINKED PAGES

    Route::get('admin/settings', 'admin\ekom\EkomAdminController@settings');
    Route::post('admin/update-setting', 'admin\ekom\EkomAdminController@update_setting');
    Route::get('admin/report-management', 'admin\ekom\EkomAdminController@report_management');
    Route::get('admin/activity-management', 'admin\ekom\EkomAdminController@activity_management');
    Route::get('admin/purchase-management', 'admin\ekom\EkomAdminController@purchase_management');
    Route::get('admin/transaction', 'admin\ekom\EkomAdminController@transaction');


    // KPI REPORT SETTINGS
    Route::group(['prefix' => 'admin/setting/kpi'], function () {
        Route::get('', 'admin\ekom\KpiController@index');
        Route::get('add', 'admin\ekom\KpiController@add');
        Route::post('store', 'admin\ekom\KpiController@store');
        Route::get('edit/{id}', 'admin\ekom\KpiController@edit');
        Route::post('update/{id}', 'admin\ekom\KpiController@update');
        Route::post('change-status', 'admin\ekom\KpiController@change_status');
        Route::post('delete', 'admin\ekom\KpiController@delete');
    });


    Route::get('appsys/userlogininformation', 'admin\system\SystemReport@userLoginInformation');

    Route::post('recent-order-list/admin/{from}/{to}', 'admin\ekom\EkomAdminController@recent_order_list');

    Route::get('admin/export-udc', 'admin\ekom\EkomAdminController@export_udc');
    Route::get('testOrders', 'DummyController@test_orders');

    Route::get('deleteOrdersWithOrderdetails', 'DummyController@deleteOrdersWithOrderdetails');

    //PARTNERS PROMOTIONS  // OFFERS
    Route::get('admin/offers', 'admin\ekom\EkomAdminController@offers');
    Route::get('admin/add-offer', 'admin\ekom\EkomAdminController@add_offer');
    Route::post('admin/save-offer', 'admin\ekom\EkomAdminController@save_offer');
    Route::get('admin/edit-offer', 'admin\ekom\EkomAdminController@edit_offer');
    Route::post('admin/update-offer', 'admin\ekom\EkomAdminController@update_offer');
    Route::post('admin/offer/change-status', 'admin\ekom\EkomAdminController@change_offer_status');
    Route::post('admin/reports/show-udc-overview', 'admin\ekom\AdminReportController@show_udc_overview');
    Route::get('admin/reports/logistic', 'admin\ekom\AdminReportController@logistic_overview');
    Route::post('admin/reports/show-logistic-overview', 'admin\ekom\AdminReportController@show_logistic_overview');

    /* NOTICE */
    Route::get('admin/notices', 'admin\ekom\EkomAdminController@notices');
    Route::get('admin/notice', 'admin\ekom\EkomAdminController@add_notice');
    Route::post('admin/notice', 'admin\ekom\EkomAdminController@store_notice');
    Route::get('admin/notice/{id}', 'admin\ekom\EkomAdminController@edit_notice');
    Route::post('admin/notice/{id}', 'admin\ekom\EkomAdminController@update_notice');
    Route::get('admin/notice/delete/{id}', 'admin\ekom\EkomAdminController@delete_notice');
    Route::get('admin/notice/change-notice-status/{id}/{status}', 'admin\ekom\EkomAdminController@change_notice_status');


	//COMMISSION DISBURSEMENT
    Route::get('admin/disburesed-commission-list', 'admin\ekom\EkomEpController@disburesed_commission_list');
    Route::get('admin/disburesement-invoice/{id}', 'admin\ekom\EkomEpController@disburesement_invoice');
    Route::get('admin/reports/commission-overview', 'admin\ekom\EkomEpController@commission_overview');
    Route::post('admin/reports/commission-overview', 'admin\ekom\EkomEpController@commission_overview');
	
    //SERVER LOG
    Route::get('get-order-log', 'admin\ekom\OrderManagementController@get_order_log');
    Route::get('top-udc', 'admin\ekom\EkomAdminController@top_udc');


    Route::get('udc-package', "DummyController@udc_package");

    //PAYWELL SECTION

    Route::get('admin/allpaywelld', 'admin\ekom\PaywellTopupController@allpaywelldeposits');
    Route::get('admin/allpaywelld/{id}', 'admin\ekom\PaywellTopupController@allpaywelldeposits');
    Route::get('admin/paywellpendingd', 'admin\ekom\PaywellTopupController@paywellpendingd');
    Route::get('admin/paywellpendingd/{id}', 'admin\ekom\PaywellTopupController@paywellpendingd');
    Route::get('admin/paywellcanceld', 'admin\ekom\PaywellTopupController@canceldeposits');
    Route::get('admin/paywellcanceld/{id}', 'admin\ekom\PaywellTopupController@canceldeposits');
    Route::get('admin/topup_history', 'admin\ekom\PaywellTopupController@topup_history');
    Route::get('admin/topup_history/{id}', 'admin\ekom\PaywellTopupController@topup_history');
    Route::post('admin/changedepositstatus', 'admin\ekom\PaywellTopupController@action');
    
    Route::get('admin/getrepeatedorders', 'admin\ekom\AdminReportController@getrepeatedorders');
    Route::get('admin/toptensearchedproducts', 'admin\ekom\AdminReportController@toptensearchedproducts');
    
});
Route::get('udc_overview_cron_script', 'admin\ekom\AdminReportController@udc_overview_cron_script');


/*
 * LP PANEL
 * */

//LP AUTH
Route::get('lp/login', 'admin\lp\LogisticPartnerController@showLoginForm');
Route::post('lp/check-login', 'admin\lp\LogisticPartnerController@login');

Route::middleware(['lpAuth'])->group(function () {

    Route::post('recent-order-list/lp/{from}/{to}', 'admin\ekom\AdminReportController@lp_recent_order_list');

    Route::get('lp', 'admin\lp\LogisticPartnerController@index');
    Route::get('lp/profile', 'admin\lp\LogisticPartnerController@myProfile');
    Route::get('lp/report', 'admin\lp\LogisticPartnerController@report');

    Route::get('lp/orders', 'admin\lp\LogisticPartnerController@lpOrders');
    Route::get('lp/order-details/{order_code}', 'admin\lp\LogisticPartnerController@order_details');
    Route::get('lp/oder-tracking/{order_code}', 'admin\lp\LogisticPartnerController@oder_tracking');
    Route::get('lp/oder-tracking', 'admin\lp\LogisticPartnerController@oder_tracking');
    Route::post('lp/change-order-status', 'admin\lp\LogisticPartnerController@change_order_status');
    Route::post('lp/save-order-tracking-message', 'admin\lp\LogisticPartnerController@save_order_tracking_message');

    Route::get('lp/packages', 'admin\lp\LogisticPartnerController@lpPackageEdit');
    Route::post('lp/update-packages', 'admin\lp\LogisticPartnerController@lpPackageUpdate');
    Route::post('lp/package-location', 'admin\lp\LogisticPartnerController@package_location');
    Route::post('lp/save-package', 'admin\lp\LogisticPartnerController@save_package');
    Route::post('lp/logout', 'admin\lp\LogisticPartnerController@logout')->name('lp-logout');

    Route::get('country-location', 'admin\LocationController@get_next_locations');
    
    
});


/*
 * EP Panel
 * */

//EP AUTH
Route::get('ep/login', 'admin\ep\EcommercePartnerController@showLoginForm');
Route::post('admin/ep/check-login', 'admin\ep\EcommercePartnerController@login');

Route::middleware(['epAuth'])->group(function () {
    Route::post('recent-order-list/ep/{from}/{to}', 'admin\ekom\AdminReportController@ep_recent_order_list');
    Route::get('ep', 'admin\ep\EcommercePartnerController@index');
    Route::get('ep/orders', 'admin\ep\EcommercePartnerController@epOrders');
    Route::get('ep/profile', 'admin\ep\DummyController@myProfile');
    Route::get('ep/report', 'admin\ep\DummyController@report');

    Route::post('ep/logout', 'admin\ep\EcommercePartnerController@logout')->name('ep-logout');
    Route::get('ep/dashboard', 'admin\ep\EcommercePartnerController@orders');
    Route::get('ep/order-details/{order_code}', 'admin\ep\EcommercePartnerController@order_details');
    Route::get('ep/oder-tracking/{order_code}', 'admin\ep\EcommercePartnerController@oder_tracking');
    Route::get('ep/oder-tracking', 'admin\ep\EcommercePartnerController@oder_tracking');
    Route::post('ep/change-order-status', 'admin\ep\EcommercePartnerController@change_order_status');
    Route::get('ep/udc-commission', 'admin\ep\EcommercePartnerController@udc_commission_report');
    Route::post('ep/udc-commission', 'admin\ep\EcommercePartnerController@udc_commission_report');
	//COMMISSION DISBURSEMENT SECTION
    Route::post('ep/commission-disburse', 'admin\ep\EcommercePartnerController@commission_disburse');
    Route::get('ep/disburesed-commission-list', 'admin\ep\EcommercePartnerController@disburesed_commission_list');
    Route::get('ep/disburesement-invoice/{id}', 'admin\ep\EcommercePartnerController@disburesement_invoice');
	
	Route::get('ep/commission-disburse', 'admin\ep\EcommercePartnerController@commission_disburse');
});


/*
 * UDC panel
 * */

Route::get('/', 'Frontend\EkomFrontController@ekom_front');

Route::middleware(['DcAuth'])->group(function () {

    Route::post('recent-order-list/dc/{from}/{to}', 'admin\ekom\AdminReportController@dc_recent_order_list');

    //PRODUCT SEARCHING
//    Route::get('search/{search_text}', 'Frontend\EkomFrontController@search');
    Route::get('search', 'Frontend\EkomFrontController@search_product');
    Route::get('search-product', 'Frontend\EkomFrontController@search_product');

    //UDC FRONT
    //Route::get('/', 'Frontend\EkomFrontController@ekom_front');
    Route::get('/go-to-ep/{ep_id}', 'Frontend\EkomFrontController@go_to_ep');

    //LANGUAGE
    Route::get('switch-language/{lang}', array(
        'Middleware' => 'LanguageSwitcher',
        'uses' => 'Frontend\EkomFrontController@switch_language'
    ));

    //UDC DASHBOARD
    Route::get('udc', 'admin\udc\UdcAdminController@dashboard');
    Route::get('udc/profile', 'admin\udc\UdcAdminController@myProfile');

    //UDC PRODUCTS
    Route::get('udc/product-list', 'admin\udc\ProductManagement@dccpProductList');
    Route::get('udc/add-product', 'admin\udc\ProductManagement@add_product');
    Route::post('udc/store-product', 'admin\udc\ProductManagement@store_product');
    Route::get('udc/edit-product/{product_id}', 'admin\udc\ProductManagement@edit_product');
    Route::post('udc/update-product', 'admin\udc\ProductManagement@update_product');

    /*Udc Seller Management*/
    Route::get('udc/seller-list', 'admin\udc\ProductManagement@udcSellerList')->name('udc.sellerList');
    Route::get('udc/add-seller', 'admin\udc\ProductManagement@addSeller')->name('udc.addSeller');
    Route::post('udc/store-seller', 'admin\udc\ProductManagement@storeSeller')->name('udc.storeSeller');
    Route::get('udc/{id}/edit-seller', 'admin\udc\ProductManagement@editSeller')->name('udc.editSeller');
    Route::post('udc/{id}/update-seller', 'admin\udc\ProductManagement@updateSeller')->name('udc.updateSeller');

    /*Udc Customer Management*/
    Route::get('udc/customer-list', 'admin\udc\UdcAdminController@udcCustomerList')->name('udc.customerList');
    Route::get('udc/customer/{id}/orders', 'admin\udc\UdcAdminController@udc_customer_orders');
    Route::get('udc/add-customer', 'admin\udc\UdcAdminController@addCustomer')->name('udc.addCustomer');
    Route::post('udc/store-customer', 'admin\udc\UdcAdminController@storeCustomer')->name('udc.storeCustomer');
    Route::get('udc/{id}/edit-customer', 'admin\udc\UdcAdminController@editCustomer')->name('udc.editCustomer');
    Route::post('udc/{id}/update-customer', 'admin\udc\UdcAdminController@updateCustomer')->name('udc.updateCustomer');

    //UDC PURCHASES
    Route::get('udc/purchases', 'admin\udc\OrderManagementController@purchases');
    Route::post('udc/purchases', 'admin\udc\OrderManagementController@purchases');
    Route::post('udc/change-order-status', 'admin\udc\OrderManagementController@change_order_status');
    Route::get('udc/order-details/{order_id}', 'admin\udc\OrderManagementController@order_details');
    Route::get('udc/invoice/{order_id}', 'admin\udc\OrderManagementController@invoice');

    //TRANSACTIONs
    Route::get('udc/transactions', 'admin\udc\UdcAdminController@transactions');
    Route::get('mobile-bank-information', 'admin\udc\UdcAdminController@mobile_bank_information');
    Route::post('update-mobile-bank-information', 'admin\udc\UdcAdminController@update_mobile_bank_information');

    //UDC COMMISSION OVERVIEW
    Route::get('udc/udc-commission-overview', 'admin\udc\UdcAdminController@udc_commission_overview');
    Route::get('udc/commission-disburse-details/{ep_id}', 'admin\udc\UdcAdminController@commission_disburse_details');
    Route::post('udc/commission-disburse-details/{ep_id}', 'admin\udc\UdcAdminController@commission_disburse_details');


    Route::get('udc/sales', 'admin\udc\UdcAdminController@sales');
    Route::get('udc/report', 'admin\udc\UdcAdminController@report');
    //Route::get('udc/{id}/delete-seller', 'admin\udc\ProductManagement@deleteSeller')->name('udc.deleteSeller');

    Route::get('cart', 'Frontend\CartController@cart');
    Route::get('cart/remove-all', 'Frontend\CartController@remove_cart');
    Route::get('checkout-ep', 'Frontend\CheckoutController@checkout');
    Route::post('select-lp', 'Frontend\CheckoutController@select_lp');
    Route::get('checkout-step-2', 'Frontend\CheckoutController@checkout_step_2');
    Route::get('checkout-step-3', 'Frontend\CheckoutController@checkout_step_3');
    Route::post('send-otc', 'Frontend\CheckoutController@send_otc');
    Route::post('confirm-otc', 'Frontend\CheckoutController@confirm_otc');
    //PLACE ORDER
    Route::get('place-order', 'Frontend\OrderController@place_order');
    //DC CUSTOMER AND THEIR PAYMENT INFORMATION
    Route::get('invoice/{order_code}', 'Frontend\OrderController@invoice');
    Route::post('save-customer-payment', 'Frontend\OrderController@save_customer_payment');
    Route::get('save-dc-customer-details', 'Frontend\OrderController@save_dc_customer_details');

    //Order-Tracking
    Route::get('udc/order-tracking/{order_id}', 'admin\udc\OrderManagementController@oder_tracking');
    Route::get('udc/order-tracking', 'admin\udc\OrderManagementController@oder_tracking');

    Route::get('thanks-b2b', 'Frontend\CheckoutController@thanks_b2b');
    Route::get('checked-popup', 'Frontend\EkomFrontController@checked_popup');
    Route::get('partners', 'Frontend\EkomFrontController@partners');

    //AUTO SEARCHING
    Route::post('frontend/datalist', 'Frontend\EkomFrontController@datalist')->name('frontend.search.datalist');
    Route::post('frontend/deleteRow', 'Frontend\EkomFrontController@deleteRow')->name('frontend.search.deleteRow');

    //NEW ORDER TOAST
    Route::get('new-order-toast', 'Frontend\EkomFrontController@new_order_toast');

});
Route::get('logout', 'partnerController@logout');
Route::get('no-contact-number', 'partnerController@no_contact_number');//ORDER COMPLETION
Route::get('completed', 'Frontend\EkomFrontController@completed');

/*
 * END UDC PANEL
 * */

//partner Dummy Login
Route::get('test/login', 'DummyController@partnerLogin');
Route::get('login', 'DummyController@partnerLogin');
Route::get('sand-box/login', 'DummyController@partnerLogin');
Route::post('partner_login', 'partnerController@partner_login');
Route::get('partner/{id}', 'partnerController@front');
Route::get('under-construction', function () {
    return view('under-construction');
});

Route::get('phpinf', function () {
//    return phpinfo();
});


Route::get('/all-user-csv', function () {

    $table = \App\models\User::all();
    $filename = "tweets.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('id', 'center id', 'name', 'created at'));

    foreach ($table as $row) {
        fputcsv($handle, array($row->id, $row->center_id, $row->center_name, $row->created_at));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );

    return Response::download($filename, 'tweets.csv', $headers);
});


Route::get('/export', 'DummyController@export');


Route::get('othoba', function () {
     $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://103.206.184.66/api/es/search?search_text=mobile&search_query=mobile&orderway=desc&limit=3&offset=0&secret=cDtbIGZlWztcOzthJ2EgJ11zYSdzYScKCg==&consumer_key=YXhhdmFueXR5dHljd3phUVtbWy5MLEpPCg==&consumer_secret=cDtbIGZlWztcOzthJ2EgJ11zYSdzYScKCg==&search=mobile&per_page=3",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Postman-Token: dbe3b8d8-4470-4a74-8dc3-63abc03fcbed",
                "api_key: cDtbIGZlWztcOzthJ2EgJ11zYSdzYScKCg==",
                "authorization: YXhhdmFueXR5dHljd3phUVtbWy5MLEpPCg=="
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        dd($response);
});


Route::get('/csv-export', function () {

    $users = \App\models\User::all();

    $csv = \League\Csv\Writer::createFromFileObject(new SplTempFileObject());

    $header = \Illuminate\Database\Schema::getColumnListing('users');

    $csv->insertOne($header);

    foreach ($users as $user) {
        $csv->insertOne($user->toArray());
    }

    $csv->output("\user.csv");

});

Route::get('/barcode', function(){
    \App\Libraries\PlxUtilities::generate_barcode("BDPC9999");
});
Route::get('/getexcel', 'admin\ekom\AdminReportController@getPrevExcelCommission');

// Route::get('get_null_orders', function (){
//     $get_orders = \App\models\Order::whereNull('order_code')->get();
//     $order_ids = array();

//     foreach ($get_orders as $value){
//         $order_ids[] = $value->id;
//         \App\models\OrderDetail::where('order_id', $value->id )->delete();
//     }
//     \App\models\Order::destroy($order_ids);
//     dd($order_ids);
// });

Route::get('/cacheClean', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
//    Artisan::call('auth:clear-resets');
    Session::flush();
    return ("Cleared all Type Of caches to Ashes !");
});