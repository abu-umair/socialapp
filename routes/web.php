<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', 'HomeController@index')
//     ->name('home');

Route::get('/', 'Auth\LoginnController@showLogin')
// Route::get('/', 'Auth\LoginController@showLoginForm')
    ->name('home');
    
// login custom
    // Route::post('logincustom', 'Otentikasi\OtentikasiController@login')
//     ->name('logincustom');

//fcm
Route::get('/fcm', 'FcmController@index');
Route::get('/send-notification', 'FcmController@sendNotification');

//crud firebase
Route::get('create','FirebaseController@set');
Route::get('read','FirebaseController@read');
Route::get('update','FirebaseController@update');
Route::get('delete','FirebaseController@delete');

Route::get('dynamic-field', 'DynamicFieldController@index');
// update notification read_at untuk backend coolze
Route::put('updatenotification/{rules_now}', 'DashboardController@updatenotification');
// update notification read_at untuk backendcoolze
Route::post('dynamic-field/insert', 'DynamicFieldController@insert')
        ->name('dynamic-field.insert');

// routing untuk message
Route::get('/admin/messages', 'MessageController@test');

// sortable update DB ikut tutorial
Route::get('Custom','ordersController@index'); 
Route::post('Custom-sortable','ordersController@update');
// sortable update DB ikut tutorial



Route::prefix('admin')
    ->namespace('Admin') //yang di controller (namespace App\Http\Controllers\Admin;)
    ->middleware([ 'auth','admin','preventBackHistory']) // ini diisi setelah instal middleware(satpam)
    // auth & admin, cek di kernel ada auth & admin
    ->group(function () {
        //Route::get('/', 'DashboardController@index')
        //    ->name('dashboard'); //menamakan route ini
// adfood
        Route::get('/', 'DashboardAdfoodController@index')
            ->name('dashboard-adfood');
// adfood
        Route::get('/notification', 'DashboardController@allNotif')
            ->name('notificat'); //menamakan route ini   

        Route::resource('appointments-ongoing', 'OngoingController');
        Route::resource('appointments-history', 'HistoriController');    

        Route::resource('services-doctor', 'DoctorController');
        Route::resource('services-groomer', 'GroomerController');
        Route::resource('users-customer', 'CustomerController');

        // Route::resource('users', 'UsersController');
        Route::resource('services', 'ServiceController');
        
        // coolze
        Route::resource('users', 'UsersController');
        Route::resource('addresses', 'AddressController');
        Route::get('createbyid/{id}', 'AddressController@createbyid')
        ->name('createbyid');
        // Route::resource('content', 'ContentController');
        Route::resource('drivers', 'DriverController');
        Route::resource('wallets', 'WalletsController');
        Route::resource('withdraws', 'WithdrawsController');
        Route::resource('vouchers', 'VoucherController');
        Route::resource('packages', 'Coolze_packageController');
        Route::resource('customers', 'CustomerController');
        Route::resource('partners', 'PartnerController');
        Route::resource('orders', 'OrderController');
        
        
        // driver confrimation
        Route::get('driversconfirm', 'DriverController@driversconfirm')
                ->name('driversconfirm'); 
        // notifikasi utk api mobile
        Route::get('notifikasiapi', 'OrderController@notifikasiApi')
                ->name('notifikasiApi.create');   
        // Route::resource('messages', 'MessageController');
        // subpackages
        Route::get('subpackages/{id}', 'OrderController@subpackages')
        ->name('subpackages');
        // subdirver
        Route::get('subdriver/{id}', 'OrderController@subdriver')
        ->name('subdriver');
        // Route::get('profile-user/{id}', 'CustomerController@profile')
        //         ->name('user-profile-coolze');

        // download file
        Route::get('file/download/{file_name}', 'DriverController@download')
        ->name('download');
        
             
        // send notification
        Route::get('send-notification', 'SendnotificationController@index')
                ->name('send-notification');
        Route::post('save-token', 'SendnotificationController@saveToken')
                ->name('save-token');
        Route::post('send-notification', 'SendnotificationController@sendNotification')
                ->name('send.notification');  
        Route::get('historynotification', 'SendnotificationController@historynotification')
                ->name('historynotification');      
        // send notification      
        //my search navbar
        Route::post('/search','DashboardController@search')
                ->name('searchnavbar');
        //History Orders
        Route::get('history-orders', 'OrderController@history')
                ->name('history-orders');

        Route::get('history-orders/{id}', 'OrderController@scoreedit')
                ->name('history-orders.edit');
        Route::put('history-orders/{id}', 'OrderController@scoreupdate')
                ->name('history-orders.update');

        Route::get('showhistoryorder', 'OrderController@showhistoriuser');
        Route::get('showorder', 'OrderController@showorderuser');
        Route::get('stardriver', 'OrderController@stardriver');
        

        // realtime chat
        Route::get('messages', 'MessageController@test');
        Route::get('user/{query}', 'MessageController@user');
        Route::get('user-message/{id}', 'MessageController@message');
        Route::get('user-message/{id}/read', 'MessageController@read');
        Route::post('user-message', 'MessageController@send');

        // pusher tutorial ke 2 gak dipake
        Route::get('message/chatlive', 'ChatController@chat');
        // Route::get('message/send', 'ChatController@send');
        Route::post('message/send', 'ChatController@send');//gak dipake

        
        Route::get('transactions-customer/{id}', 'CustomerController@transaksi')
                ->name('transactions-customer');
        Route::get('invoice/{id}', 'CustomerController@invoice')
                ->name('invoice'); 
        Route::get('print-customers/{id}', 'CustomerController@print')
                ->name('print-customers');

        Route::get('transactions-partner/{id}', 'PartnerController@transaksi')
                ->name('transactions-partner');
        Route::get('transactions-driver/{id}', 'DriverController@transaksi')
                ->name('transactions-driver');
        // coolze

// adfood
        Route::resource('users', 'UsersController');
        Route::resource('addresses', 'AddressController');
        Route::get('createbyid/{id}', 'AddressController@createbyid')
        ->name('createbyid');
        Route::resource('drivers', 'DriverController');
        Route::resource('wallets', 'WalletsController');
        Route::resource('withdraws', 'WithdrawsController');
        Route::resource('packages', 'Coolze_packageController');
        Route::resource('partners', 'PartnerController');
        // Route::resource('orders', 'OrderController');
        // ------------------------------------------------------------------------------
        
        // stripe payment
        Route::get('stripe-checkout','StripeController@checkout');
        Route::post('stripe-checkout','StripeController@afterpayment')->name('checkout.credit-card');
        // stripe payment
        // Route::get('file','FileController@create');
        // Route::post('file','FileController@store');
        Route::get('reservation-detail/{id}','Reservation_adfoodController@reservationdetail')->name('reservation-detail');
        Route::get('rate-reservation/{id}','Reservation_adfoodController@scoreedit')->name('reservations_rate');
        Route::put('rate-reservation/{id}', 'Reservation_adfoodController@scoreupdate')->name('reservations_rate_update');
        Route::get('histories-reservation','Reservation_adfoodController@history')->name('reservations_history');
        Route::delete('delete-reservation/{id}','Reservation_adfoodController@destroy_permanen')->name('reservations_adfood_delete');
        Route::resource('reservations', 'Reservation_adfoodController');
        
        
        Route::resource('settings', 'SettingController');

        Route::resource('content', 'ContentController');
        
        Route::resource('category-adfood', 'Category_adfoodController');
        Route::delete('delete-category/{id}','Category_adfoodController@destroy_permanen')->name('category_adfood_delete');
        

        Route::delete('delete-image-promotion/{id}', 'Voucher_adfoodController@destroy_voucher')->name('vouchers_image_delete');
        Route::put('update-image-promotion/{id}', 'Voucher_adfoodController@update_image');
        Route::get('image-promotion/{id}','Voucher_adfoodController@edit_image')->name('image_voucher');
        Route::delete('delete-voucher/{id}','Voucher_adfoodController@destroy_permanen')->name('vouchers_adfood_delete');
        Route::resource('vouchers_adfood', 'Voucher_adfoodController');

        Route::resource('orivouchers-adfood', 'Orivoucher_adfoodController');
        Route::delete('delete-orivouchers/{id}','Orivoucher_adfoodController@destroy_permanen')->name('orivouchers-adfood-delete');

        Route::resource('stripes-adfood', 'Stripe_adfoodController');
        Route::delete('delete-stripes/{id}','Stripe_adfoodController@destroy_permanen')->name('stripes-adfood-delete');

        Route::resource('subscription-adfood', 'Subscription_adfoodController');
        Route::delete('delete-subscription/{id}','Subscription_adfoodController@destroy_permanen')->name('subscription-adfood-delete');

        Route::delete('delete-image-menus/{id}', 'Merchant_adfoodController@destroy_menus')->name('menus_image_delete');
        Route::put('update-image-menus/{id}', 'Merchant_adfoodController@update_image');
        Route::get('image-menus/{id}','Merchant_adfoodController@edit_image')->name('image_menus');
        Route::delete('delete-merchant/{id}','Merchant_adfoodController@destroy_permanen')->name('merchants_adfood_delete');
        Route::resource('merchants', 'Merchant_adfoodController');
        Route::get('avg-merchant-byid/{id}', 'Merchant_adfoodController@show_avg_merhant_byid');
        Route::get('user-profile/{id}', 'Merchant_adfoodController@profile')
                ->name('profile-user');
        
        Route::delete('delete-customer/{id}','Customer_adfoodController@destroy_permanen')->name('customers_adfood_delete');
        Route::resource('customers', 'Customer_adfoodController');

        Route::delete('delete-image-food/{id}', 'Food_adfoodController@destroy_food')->name('foods_image_delete');
        Route::put('update-image-food/{id}', 'Food_adfoodController@update_image');
        Route::get('image-food/{id}','Food_adfoodController@edit_image')->name('image_food');
        Route::delete('delete-food/{id}','Food_adfoodController@destroy_permanen')->name('foods_adfood_delete');
        Route::resource('foods', 'Food_adfoodController');

        Route::resource('layout-foods', 'Layoutfood_adfoodController');
        Route::post('layoutfoodsortable', 'Layoutfood_adfoodController@layoutfoodsortable');

        Route::resource('layout-merchants', 'Layoutmerchant_adfoodController');
        Route::post('layoutmerchantsortable', 'Layoutmerchant_adfoodController@layoutmerchantsortable');
// adfood
        
        // restore soft Delete
        Route::post('/services-doctor/restore', 'DoctorController@restore')
                ->name('services-doctor.restore');
        Route::post('/services-groomer/restore', 'GroomerController@restore')
                ->name('services-groomer.restore');
        Route::post('/users-customer/restore', 'CustomerController@restore')
                ->name('users-customer.restore');          
        // restore soft Delete

        // Route::get('/profile-customer/{id}', 'CustomerController@profile')
        //         ->name('users-customer.profile');
        Route::get('/profile-doctor/{id}', 'DoctorController@profile')
                ->name('services-doctor.profile');
        Route::get('/profile-groomer/{id}', 'GroomerController@profile')
                ->name('services-groomer.profile');

        Route::get('/transactions-groomer/{id}', 'GroomerController@transaksi')
                ->name('transactions-groomer');
        Route::get('/transactions-doctor/{id}', 'DoctorController@transaksi')
                ->name('transactions-doctor');
        

        Route::get('/invoice-groomer/{id}', 'GroomerController@invoice')
                ->name('invoice-groomer');
        Route::get('/invoice-doctor/{id}', 'DoctorController@invoice')
                ->name('invoice-doctor');
        

        Route::get('/score-product/{id}', 'OngoingController@scoreCreate')
                ->name('score.create');
        Route::put('/score-product/store/{id}', 'OngoingController@scoreStore')
                ->name('score.store');

        

        
        
    });
    
        
Auth::routes(['verify' => true]);