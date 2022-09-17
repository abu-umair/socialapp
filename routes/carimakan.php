<?php

use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('public')
    // ->namespace('Admin') //yang di controller (namespace App\Http\Controllers\Admin;)
    ->middleware(['jwt.verify','preventBackHistory'])
    //->middleware(['auth', 'admin','preventBackHistory']) // ini diisi setelah instal middleware(satpam)
    // auth & admin, cek di kernel ada auth & admin
    ->group(function () {

    Route::get('/', 'DashboardController@index')
                ->name('dashboard'); //menamakan route ini


// adfood
        
        
        
        // Route::resource('merchants', 'Merchant_adfoodController');
        Route::get('merchants', 'Merchant_adfoodController@index');
        Route::post('merchants', 'Merchant_adfoodController@store');
        Route::get('merchants/{id}', 'Merchant_adfoodController@show');
        // Route::put('merchants/{id}', 'Merchant_adfoodController@update');
        Route::post('merchants/{id}', 'Merchant_adfoodController@update');
        Route::delete('merchants/{id}', 'Merchant_adfoodController@destroy');
        Route::delete('delete-merchant/{id}','Merchant_adfoodController@destroy_permanen')->name('merchants_adfood_delete');
        Route::get('image-menus-all', 'Merchant_adfoodController@indexgallery');
        Route::get('image-menus-id/{id}', 'Merchant_adfoodController@showgallery');
        Route::delete('delete-image-menus/{id}', 'Merchant_adfoodController@destroy_menus')->name('menus_image_delete');
        Route::put('update-image-menus/{id}', 'Merchant_adfoodController@update_image');
        Route::get('image-menus/{id}','Merchant_adfoodController@edit_image')->name('image_menus');
        Route::get('avg-merchant-byid/{id}', 'Merchant_adfoodController@show_avg_merhant_byid');

        // Route::resource('content', 'ContentController');
        Route::get('content', 'ContentController@index');
        Route::post('content', 'ContentController@store');
        Route::get('content/{id}', 'ContentController@show');
        Route::post('content/{id}', 'ContentController@update');
        Route::delete('content/{id}', 'ContentController@destroy');

        // Route::resource('category', 'Category_adfoodController');
        Route::get('category-adfood', 'Category_adfoodController@index');
        Route::post('category-adfood', 'Category_adfoodController@store');
        Route::get('category-adfood/{id}', 'Category_adfoodController@show');
        Route::post('category-adfood/{id}', 'Category_adfoodController@update');
        Route::delete('category-adfood/{id}', 'Category_adfoodController@destroy');

        // Route::resource('customers', 'Customer_adfoodController');
        Route::get('customers', 'Customer_adfoodController@index');
        Route::post('customers', 'Customer_adfoodController@store');
        Route::get('customers/{id}', 'Customer_adfoodController@show');
        // Route::put('customers/{id}', 'Customer_adfoodController@update');
        Route::post('customers/{id}', 'Customer_adfoodController@update');
        Route::delete('customers/{id}', 'Customer_adfoodController@destroy');
        Route::delete('delete-customer/{id}','Customer_adfoodController@destroy_permanen')->name('customers_adfood_delete');

        // Route::resource('foods', 'Food_adfoodController');
        Route::get('foods', 'Food_adfoodController@index');
        Route::post('foods', 'Food_adfoodController@store');
        Route::get('foods/{id}', 'Food_adfoodController@show');
        Route::post('foods/{id}', 'Food_adfoodController@update');
        Route::delete('foods/{id}', 'Food_adfoodController@destroy');
        Route::get('foods-merchant/{id}', 'Food_adfoodController@showbymerchant');
        // Route::get('foods-subparameter/{idcategory}/{merchanname}/{idpromotion}', 'Food_adfoodController@showsubparameter');
        Route::get('foods-subparameter', 'Food_adfoodController@showsubparameter');
        Route::delete('delete-food/{id}','Food_adfoodController@destroy_permanen')->name('foods_adfood_delete');
        Route::get('image-food-all', 'Food_adfoodController@indexgallery');
        Route::get('image-food-id/{id}', 'Food_adfoodController@showgallery');
        Route::delete('delete-image-food/{id}', 'Food_adfoodController@destroy_food')->name('foods_image_delete');
        Route::put('update-image-food/{id}', 'Food_adfoodController@update_image');

        // Route::resource('vouchers_adfood', 'Voucher_adfoodController');
        Route::get('vouchers-adfood', 'Voucher_adfoodController@index');
        Route::post('vouchers-adfood', 'Voucher_adfoodController@store');
        Route::get('vouchers-adfood/{id}', 'Voucher_adfoodController@show');
        Route::post('vouchers-adfood/{id}', 'Voucher_adfoodController@update');
        Route::delete('vouchers-adfood/{id}', 'Voucher_adfoodController@destroy');
        Route::delete('delete-voucher/{id}','Voucher_adfoodController@destroy_permanen')->name('vouchers_adfood_delete');
        Route::get('image-voucher-all', 'Voucher_adfoodController@indexgallery');
        Route::get('image-voucher-id/{id}', 'Voucher_adfoodController@showgallery');
        Route::delete('delete-image-voucher/{id}', 'Voucher_adfoodController@destroy_voucher')->name('foods_image_delete');
        Route::put('update-image-voucher/{id}', 'Voucher_adfoodController@update_image');

        // orivoucher
        // Route::resource('orivouchers-adfood', 'Orivoucher_adfoodController');
        Route::get('promotions-adfood', 'Orivoucher_adfoodController@index');
        Route::post('promotions-adfood', 'Orivoucher_adfoodController@store');
        Route::get('promotions-adfood/{id}', 'Orivoucher_adfoodController@show');
        Route::post('promotions-adfood/{id}', 'Orivoucher_adfoodController@update');
        Route::delete('promotions-adfood/{id}', 'Orivoucher_adfoodController@destroy');
        Route::get('promotions-adfood-merchant/{id}', 'Orivoucher_adfoodController@showbymerchant');
        Route::delete('delete-promotions/{id}','Orivoucher_adfoodController@destroy_permanen');
        
        
        // Route::resource('subscription-adfood', 'Subscription_adfoodController');
        Route::get('subscription-adfood', 'Subscription_adfoodController@index');
        Route::post('subscription-adfood', 'Subscription_adfoodController@store');
        Route::get('subscription-adfood/{id}', 'Subscription_adfoodController@show');
        Route::post('subscription-adfood/{id}', 'Subscription_adfoodController@update');
        Route::delete('subscription-adfood/{id}', 'Subscription_adfoodController@destroy');
        Route::delete('delete-subscription/{id}','Subscription_adfoodController@destroy_permanen');

        // Route::resource('stripes-adfood', 'Stripe_adfoodController');
        Route::get('stripes-adfood', 'Stripe_adfoodController@index');
        Route::post('stripes-adfood', 'Stripe_adfoodController@store');
        Route::get('stripes-adfood/{id}', 'Stripe_adfoodController@show');
        Route::get('stripes-adfood-bymerchat/{id}', 'Stripe_adfoodController@show_by_merchant');
        Route::put('stripes-adfood/{id}', 'Stripe_adfoodController@update');
        Route::delete('stripes-adfood/{id}', 'Stripe_adfoodController@destroy');
        Route::delete('delete-stripes/{id}','Stripe_adfoodController@destroy_permanen');

        // Route::resource('reservations', 'Reservation_adfoodController');
        Route::get('reservations', 'Reservation_adfoodController@index');
        Route::post('reservations', 'Reservation_adfoodController@store');
        Route::get('reservations/{id}', 'Reservation_adfoodController@show');
        Route::put('reservations/{id}', 'Reservation_adfoodController@update');
        Route::delete('reservations/{id}', 'Reservation_adfoodController@destroy');
        Route::put('rate-reservation/{id}', 'Reservation_adfoodController@scoreupdate')->name('reservations_rate_update');
        Route::get('reservations-merc-cust/{id}', 'Reservation_adfoodController@showbymerchantcustomerongoing');
        Route::get('reservations-history-merc-cust/{id}', 'Reservation_adfoodController@showbymerchantcustomerhistori');
        Route::get('reservations-history','Reservation_adfoodController@history')->name('reservations_history');
        Route::delete('delete-reservation/{id}','Reservation_adfoodController@destroy_permanen')->name('reservations_adfood_delete');
        Route::get('notifikasiapi/{id}', 'Reservation_adfoodController@notifikasiapi');


        Route::get('subscriptions-merchants', 'Subscriptionsmerchant_adfoodController@index');
        Route::post('subscriptions-merchants', 'Subscriptionsmerchant_adfoodController@store');
        Route::get('subscriptions-merchants/{id}', 'Subscriptionsmerchant_adfoodController@show');
        Route::get('subscriptions-id-merchants/{id}', 'Subscriptionsmerchant_adfoodController@show_id_merchant');
        Route::get('subscriptions-id-subscriptions/{id}', 'Subscriptionsmerchant_adfoodController@show_id_subscription');
        Route::put('subscriptions-merchants/{id}', 'Subscriptionsmerchant_adfoodController@update');
        Route::delete('subscriptions-merchants/{id}', 'Subscriptionsmerchant_adfoodController@destroy');
        Route::delete('delete-subscriptions-merchants/{id}','Subscriptionsmerchant_adfoodController@destroy_permanen');

        // Route::resource('layout-foods', 'Layoutfood_adfoodController');
        Route::get('layout-foods', 'Layoutfood_adfoodController@index');

        // Route::resource('layout-merchants', 'Layoutmerchant_adfoodController');
        Route::get('layout-merchants', 'Layoutmerchant_adfoodController@index');
// adfood


    // stripe payment
    Route::get('stripe-checkout','StripeController@checkout');
    Route::post('stripe-checkout','StripeController@afterpayment')->name('checkout.credit-card');
    // stripe payment

    
    // Route::resource('appointments-ongoing', 'OngoingController');
    Route::get('appointments-ongoing', 'OngoingController@index');
    Route::post('appointments-ongoing', 'OngoingController@store');
    Route::get('appointments-ongoing/{id}', 'OngoingController@show');
    Route::put('appointments-ongoing/{id}', 'OngoingController@update');
    Route::delete('appointments-ongoing/{id}', 'OngoingController@destroy');

    // Route::resource('appointments-history', 'HistoriController'); 
    Route::get('appointments-history', 'HistoriController@index');
    Route::post('appointments-history', 'HistoriController@store');
    Route::get('appointments-history/{id}', 'HistoriController@show');
    Route::put('appointments-history/{id}', 'HistoriController@update');
    Route::delete('appointments-history/{id}', 'HistoriController@destroy');  
      

        // Route::resource('services-doctor', 'DoctorController');        
    Route::get('services-doctor', 'DoctorController@index');
    Route::post('services-doctor', 'DoctorController@store');
    Route::get('services-doctor/{id}', 'DoctorController@show');
    Route::put('services-doctor/{id}', 'DoctorController@update');
    Route::delete('services-doctor/{id}', 'DoctorController@destroy');
    
    // Route::resource('services-groomer', 'GroomerController');
    Route::get('services-groomer', 'GroomerController@index');
    Route::post('services-groomer', 'GroomerController@store');
    Route::get('services-groomer/{id}', 'GroomerController@show');
    Route::put('services-groomer/{id}', 'GroomerController@update');
    Route::delete('services-groomer/{id}', 'GroomerController@destroy');

    // Route::resource('users-customer', 'CustomerController');
    // Route::get('users-customer', 'CustomerController@index');
    // Route::post('users-customer', 'CustomerController@store');
    // Route::get('users-customer/{id}', 'CustomerController@show');
    // Route::put('users-customer/{id}', 'CustomerController@update');
    // Route::delete('users-customer/{id}', 'CustomerController@destroy');




    

    Route::get('services', 'ServiceController@index');
    Route::post('services', 'ServiceController@store');
    Route::get('services/{id}', 'ServiceController@show');
    Route::put('services/{id}', 'ServiceController@update');
    Route::delete('services/{id}', 'ServiceController@destroy');

    Route::put('/score-product/store/{id}', 'OngoingController@scoreStore')
                ->name('score.store');
                
    

    Route::get('/showongoing', 'OngoingController@showongoinguser');
    Route::get('/showhistory', 'HistoriController@showhistoriuser');

    Route::get('/ulasandoctor/{id}', 'DoctorController@ulasandoctor');
    
    Route::get('/ulasangroomer/{id}', 'GroomerController@ulasangroomer');
    
    // COOLZE
    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::get('users/{id}', 'UsersController@show');
    Route::put('users/{id}', 'UsersController@update');
    Route::delete('users/{id}', 'UsersController@destroy');

    Route::get('partners', 'PartnerController@index');
    Route::post('partners', 'PartnerController@store');
    Route::get('partners/{id}', 'PartnerController@show');
    Route::put('partners/{id}', 'PartnerController@update');
    Route::delete('partners/{id}', 'PartnerController@destroy');

    // Route::get('customers', 'CustomerController@index');
    // Route::post('customers', 'CustomerController@store');
    // Route::get('customers/{id}', 'CustomerController@show');
    // Route::put('customers/{id}', 'CustomerController@update');
    // Route::delete('customers/{id}', 'CustomerController@destroy');

    Route::get('drivers', 'DriverController@index');
    Route::post('drivers', 'DriverController@store');
    Route::get('drivers/{id}', 'DriverController@show');
    Route::put('drivers/{id}', 'DriverController@update');
    Route::delete('drivers/{id}', 'DriverController@destroy');

    Route::get('packages', 'Coolze_packageController@index');
    Route::post('packages', 'Coolze_packageController@store');
    Route::get('packages/{id}', 'Coolze_packageController@show');
    Route::put('packages/{id}', 'Coolze_packageController@update');
    Route::delete('packages/{id}', 'Coolze_packageController@destroy');
    
    Route::get('wallets', 'WalletsController@index');
    Route::post('wallets', 'WalletsController@store');
    Route::get('wallets/{id}', 'WalletsController@show');
    Route::put('wallets/{id}', 'WalletsController@update');
    Route::delete('wallets/{id}', 'WalletsController@destroy');


    Route::resource('withdraws', 'WithdrawsController');
    Route::get('withdraws', 'WithdrawsController@index');
    Route::post('withdraws', 'WithdrawsController@store');
    Route::get('withdraws/{id}', 'WithdrawsController@show');
    Route::put('withdraws/{id}', 'WithdrawsController@update');
    Route::delete('withdraws/{id}', 'WithdrawsController@destroy');

    Route::get('vouchers', 'VoucherController@index');
    Route::post('vouchers', 'VoucherController@store');
    Route::get('vouchers/{id}', 'VoucherController@show');
    Route::put('vouchers/{id}', 'VoucherController@update');
    Route::delete('vouchers/{id}', 'VoucherController@destroy');

    Route::get('addresses', 'AddressController@index');
    Route::post('addresses', 'AddressController@store');
    Route::get('addresses/{id}', 'AddressController@show');
    Route::put('addresses/{id}', 'AddressController@update');
    Route::delete('addresses/{id}', 'AddressController@destroy');

    // Route::get('content', 'ContentController@index');
    // Route::post('content', 'ContentController@store');
    // Route::get('content/{id}', 'ContentController@show');
    // Route::put('content/{id}', 'ContentController@update');
    // Route::delete('content/{id}', 'ContentController@destroy');

    
    Route::get('orders', 'OrderController@index');
    Route::post('orders', 'OrderController@store');
    Route::get('orders/{id}', 'OrderController@show');
    Route::put('orders/{id}', 'OrderController@update');
    Route::delete('orders/{id}', 'OrderController@destroy');

    
    Route::get('history-orders', 'OrderController@history')
                ->name('history-orders');
    Route::get('showhistoryorder', 'OrderController@showhistoriuser');
    Route::get('showorder', 'OrderController@showorderuser');
    Route::get('stardriver', 'OrderController@stardriver');
});

// forgot password custom otp adfood
Route::post('/postforgot', 'Api\ForgotPasswordController@postforgot')
->name('postforgot');
Route::post('/password/reset/new', 'Api\ResetPasswordController@updatereset');
// sms twilio
Route::post('/resettoken', 'Api\ResetPasswordController@resettoken')
->name('resettoken');
// sms twilio


// forgot Password    
Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset/', 'Api\ResetPasswordController@reset')
->name('password.resetApi');

// veryfied email api
Route::get('/email/resend', 'Api\VerificationController@resend')
        ->middleware('jwt.verify')
        ->name('verification.resend');            
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')
        ->name('verification.verifyEmail');

            // ->middleware('jwt.verify')
            // ->name('password.resetApi')     
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
