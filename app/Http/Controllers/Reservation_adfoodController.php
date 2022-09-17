<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Adfood_reservation;
use App\Users;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\ReservationRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Reservation_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items_ongoing = Adfood_reservation::with([
            'merchant','customer','merchant_lengkap'
        ])
        ->where('acc',!1)
        ->orderBy('created_at', 'desc')
        ->get();
        // $user= Auth::user()->roles;
        
        if(\Request::segment(1) == 'api') {
            
            $items = Adfood_reservation::with([
                'merchant','customer','merchant_lengkap'
            ])
            // ->where('acc',!1)
            // ->where('rate', '!=', null)
            ->where(function ($query) {
                $query->where('adfood_merchants_id','!=', null)
                        ->orWhere('adfood_customers_id','!=', null);
                })
            ->orderBy('created_at', 'desc')
            ->get();
            

            // memisahkan utk avg
            $rate_users = $items->whereIn('rate',!null); 

            //mengambil id merchants di table reservations tanpa duplikat/unique
            $id_merchants = $rate_users->pluck('adfood_merchants_id')->unique(); 
            $id_customers = $rate_users->pluck('adfood_customers_id')->unique();
            $mergeIdCustMerch = $id_customers->merge($id_merchants); //merge  id merchant & customers yg memiliki rate
            
            //mengambil avg cust & merch, kemudian menghitung avg nya
            $hasil_avg = [];
            $total = [];
            $array_disini = [];

            foreach ($mergeIdCustMerch as $id) {

                $count = $rate_users->where('adfood_merchants_id', $id )->count(); //menyaring id merchant
                if ($count == null) { //jika null id merchant,
                    $count = $rate_users->where('adfood_customers_id', $id )->count(); //tampilkan id customer
                }

                $sum = $rate_users->where('adfood_merchants_id', $id )->sum('rate'); //menyaring id merchant
                if ($sum == null) { //jika null id merchant,
                    $sum = $rate_users->where('adfood_customers_id', $id )->sum('rate'); //tampilkan id customer
                }

                $jumlahOrgReview = $count;
                $hasilrete =$sum;
                $avg = $hasilrete/$jumlahOrgReview;
                $hasil_avg[] = collect([ [$id => $avg],['countRate' => $jumlahOrgReview] ]);
                
            }

            return response()->json([
                'success'         => true,
                'avgNcountRate'   => $hasil_avg,
                // 'ongoing'         => collect([$items->where('acc',!1)]),$items_noAcc
                'ongoing'         => $items_ongoing,
                ], 200);
        }


        return view('pages.admin.reservations-adfood.index', [
            'items' => $items_ongoing
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchants = Users::with([
            'merchant'
            ])
            ->where('merchants_id','!=', null)
            ->where('status', 1)
            ->get();
        
        $customers = Users::with([
            'customer'
            ])
            ->where('customers_id','!=', null)
            ->where('status', 1)
            ->get();

        return view('pages.admin.reservations-adfood.create', [
            'customers' => $customers,
            'merchants' => $merchants
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        $data = $request->all();
        $data['acc'] = $data['status'] == 'pending' ? 0 : 1;
        $data['order_id'] = uniqid();
        
        try {
            $item = Adfood_reservation::create($data);

            // fcm (mengetahui $token, buka di url http://127.0.0.1:8000/fcm)
            $token = "ehtJYcKXMPE:APA91bFi-BA6o40OgOHEEnS1ecRZpJEOq23zlR5H23onTchEb4MRctrePkh0JJIp1QBiK5a3NhbDbYf6JUANKhHDLZ7CWOpNfyVMarsrovVqcjcNwUVHia1Ttkqul-PQrCxYEdMINIjA";  
            $from = "AAAAQjO8aPg:APA91bFhUNV4TyqhMIyeN6KnKJvU3GlnvkPV9O_7I8vXHtEA2Qc2bLBj-sNjLYYynvkAF33EbpxUwMQQU7c1MOWoi3-Fsx2KvoGs9sCbG9iUN7RBj--mxyF2TNACvasERZW9LIBpZu-U";
                $msg = array    
                    (
                        'body'  => "Post",
                        'title' => "Success Post",
                        'receiver' => 'Success',
                        'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                        'sound' => 'mySound'/*Default sound*/
                    );
                $fields = array
                        (
                            'to'        => $token,
                            'notification'  => $msg
                        );
                $headers = array
                        (
                            'Authorization: key=' . $from,
                            'Content-Type: application/json'
                        );
                //#Send Reponse To FireBase Server 
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                // dd($result);
                curl_close( $ch );
            
        } catch (QueryException $e) {
            
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'fcm' => json_decode($result),
                    // 'data' => $item
                ], 401);
            }
            return back()->with('error', 'Error Create');
        } 
        

        if(\Request::segment(1) == 'api') {
            $item = Adfood_reservation::with([
                'merchant','customer'
            ])->findOrFail($item->id);
            
            return response([
                'success'       => true,
                'id'            => $item->id,
                'order_id'      => $item->order_id,
                'merchant_id'   => $item->adfood_merchants_id,
                'name_merchant' => $item->merchant->first()->name,
                'foto_merchant' => $item->merchant->first()->foto,
                'customer_id'   => $item->adfood_customers_id,
                'name_customer' => $item->customer->first()->name,
                'foto_customer' => $item->customer->first()->foto,
                'jumlah_orang'  => $item->jumlah_orang,
                'date'          => $item->date,
                'time'          => $item->time,
                'status'        => $item->status,
                'tracking_register'                => $item->tracking_register,
                'tracking_restaurant_check'        => $item->tracking_restaurant_check,
                'tracking_confrimed_restaurant'    => $item->tracking_confrimed_restaurant,
                'tracking_done'                    => $item->tracking_done,
                'acc'           => $item->acc,
                'rate'          => $item->rate,
                'ulasan_rate'   => $item->ulasan_rate,
                'pothos_coment' => $item->pothos_coment,
                ], 200);          
        }

        // kirim notifications table
        $items_customers = Users::findOrFail($data['adfood_customers_id']);
        // $toDatabase = Adfood_reservation::where('id',$item->id)->get();
        $toDatabase = Adfood_reservation::findOrFail($item->id);
        
        $enrollmentData = [
            'description'         => 'New Order ',
            'from'                => $items_customers->name,
            'merchants_id'         => $request->adfood_merchants_id,
        ];
        // $toDatabase->notify(new InvoicePaid($enrollmentData));
        Notification::send($toDatabase, new InvoicePaid($enrollmentData));
        // kirim notifications table

        Alert::success('Reservation', $item->order_id.' Successfully Create');   
             
        if ($data['acc'] == 0) {
            return redirect()->route('reservations.index');
        } else {
            return redirect()->route('reservations_history');
        }          
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Adfood_reservation::with([
            'merchant','customer','merchant_lengkap'
        ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success'       => true,
                'id'            => $item->id,
                'order_id'      => $item->order_id,
                'merchant_id'   => $item->adfood_merchants_id,
                'name_merchant' => $item->merchant->first() ? $item->merchant->first()->name : 'data_user_telah_didelete',
                'foto_merchant' => $item->merchant->first() ? $item->merchant->first()->foto : 'data_user_telah_didelete',
                'customer_id'   => $item->adfood_customers_id,
                'name_customer' => $item->customer->first() ? $item->customer->first()->name :'data_user_telah_didelete',
                'foto_customer' => $item->customer->first() ? $item->customer->first()->foto :'data_user_telah_didelete',
                'jumlah_orang'  => $item->jumlah_orang,
                'date'          => $item->date,
                'time'          => $item->time,
                'tracking_register'                => $item->tracking_register,
                'tracking_restaurant_check'        => $item->tracking_restaurant_check,
                'tracking_confrimed_restaurant'    => $item->tracking_confrimed_restaurant,
                'tracking_done'                    => $item->tracking_done,
                'open_restaurant'                  => $item->merchant_lengkap ? $item->merchant_lengkap->open_restaurant : 'data_user_telah_didelete',
                'close_restaurant'                 => $item->merchant_lengkap ? $item->merchant_lengkap->close_restaurant : 'data_user_telah_didelete',
                'status'                           => $item->status,
                'acc'                              => $item->acc,
                'rate'                             => $item->rate,
                'ulasan_rate'                      => $item->ulasan_rate,
                'pothos_coment'                    => $item->pothos_coment,
                ], 200);
        }

        return view('pages.admin.reservations-adfood.detail', [
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Adfood_reservation::with('merchant','customer')
                ->findOrFail($id);

        $merchants = Users::with([
            'merchant'
            ])
            ->where('merchants_id','!=', null)
            ->where('status', 1)
            ->get();
        
        $customers = Users::with([
            'customer'
            ])
            ->where('customers_id','!=', null)
            ->where('status', 1)
            ->get();

        return view('pages.admin.reservations-adfood.edit', [
            'item' => $item,
            'customers' => $customers,
            'merchants' => $merchants
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationRequest $request, $id)
    {
        
        $data = $request->all();       
        $data['acc'] = $data['status'] == 'pending' ? 0 : 1;

        try {

            $item = Adfood_reservation::findOrFail($id);
            $item->update($data);

            // fcm (mengetahui $token, buka di url http://127.0.0.1:8000/fcm)
            $token = "ehtJYcKXMPE:APA91bFi-BA6o40OgOHEEnS1ecRZpJEOq23zlR5H23onTchEb4MRctrePkh0JJIp1QBiK5a3NhbDbYf6JUANKhHDLZ7CWOpNfyVMarsrovVqcjcNwUVHia1Ttkqul-PQrCxYEdMINIjA";  
            $from = "AAAAQjO8aPg:APA91bFhUNV4TyqhMIyeN6KnKJvU3GlnvkPV9O_7I8vXHtEA2Qc2bLBj-sNjLYYynvkAF33EbpxUwMQQU7c1MOWoi3-Fsx2KvoGs9sCbG9iUN7RBj--mxyF2TNACvasERZW9LIBpZu-U";
                $msg = array    
                    (
                        'body'  => "Update",
                        'title' => "Success Update",
                        'receiver' => 'Success',
                        'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                        'sound' => 'mySound'/*Default sound*/
                    );
                $fields = array
                        (
                            'to'        => $token,
                            'notification'  => $msg
                        );
                $headers = array
                        (
                            'Authorization: key=' . $from,
                            'Content-Type: application/json'
                        );
                //#Send Reponse To FireBase Server 
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                // dd($result);
                curl_close( $ch );

        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item
                    // 'status' => $sell_properties
                ], 401);
            }
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            return response([
                'success'       => true,
                'id'            => $item->id,
                'order_id'      => $item->order_id,
                'merchant_id'   => $item->adfood_merchants_id,
                'name_merchant' => $item->merchant->first()->name,
                'foto_merchant' => $item->merchant->first()->foto,
                'customer_id'   => $item->adfood_customers_id,
                'name_customer' => $item->customer->first()->name,
                'foto_customer' => $item->customer->first()->foto,
                'jumlah_orang'  => $item->jumlah_orang,
                'date'          => $item->date,
                'time'          => $item->time,
                'tracking_register'                => $item->tracking_register,
                'tracking_restaurant_check'        => $item->tracking_restaurant_check,
                'tracking_confrimed_restaurant'    => $item->tracking_confrimed_restaurant,
                'tracking_done'                    => $item->tracking_done,
                'status'        => $item->status,
                'acc'           => $item->acc,
                'rate'          => $item->rate,
                'ulasan_rate'   => $item->ulasan_rate,
                'pothos_coment' => $item->pothos_coment,
                'fcm'           => json_decode($result),
            ], 200);
        }
        Alert::success('Reservation', $item->order_id.' Successfully Updated'); 
        if ($data['acc'] == 0) {
            return redirect()->route('reservations.index');
        } else {
            return redirect()->route('reservations_history');
        }          
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Adfood_reservation::findOrFail($id);
        //delete image
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }
        
        $item->update(['status' => 0]);

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete Soft '.$item->name,
                'data' => $item
            ], 200);
        }
        Alert::success('Reservation ', $item->name.' Status Is Not Active');        
        return redirect()->route('reservations.index');
    }

    public function destroy_permanen($id)
    {
        $item = Adfood_reservation::findOrFail($id);
        
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'       => true,
                'id'            => $item->id,
                'order_id'      => $item->order_id,
                'merchant_id'   => $item->adfood_merchants_id,
                'name_merchant' => $item->merchant->first()->name,
                'foto_merchant' => $item->merchant->first()->foto,
                'customer_id'   => $item->adfood_customers_id,
                'name_customer' => $item->customer->first()->name,
                'foto_customer' => $item->customer->first()->foto,
                'jumlah_orang'  => $item->jumlah_orang,
                'date'          => $item->date,
                'time'          => $item->time,
                'tracking_register'                => $item->tracking_register,
                'tracking_restaurant_check'        => $item->tracking_restaurant_check,
                'tracking_confrimed_restaurant'    => $item->tracking_confrimed_restaurant,
                'tracking_done'                    => $item->tracking_done,
                'status'        => $item->status,
                'acc'           => $item->acc,
                'rate'          => $item->rate,
                'ulasan_rate'   => $item->ulasan_rate,
                'pothos_coment' => $item->pothos_coment,
            ], 200);
        }
        Alert::success('Reservation ', $item->order_id.' Successfully Delete');        
        // return redirect()->route('reservations.index');
        return back();
    }

    public function showbymerchantcustomerongoing($id)
    {
        $items = Adfood_reservation::with([
            'merchant','merchant_lengkap','customer','customer_lengkap'
        ])
        ->where('adfood_merchants_id',$id)
        ->orWhere('adfood_customers_id',$id)
        ->get();


        $count = $items->where('rate',!null)->count();
        $sum = $items->where('rate',!null)->sum('rate');

        
        if ($count != 0) {
            $jumlahOrgReview = $count;
            $hasilrete =$sum;
            $avg = $hasilrete/$jumlahOrgReview;
        } else {
            $jumlahOrgReview = 0;
            $avg = 0;
        }
            
        // $jumlahOrgReview = $count;
        // $hasilrete =$sum;
        $hasil_avg = collect([ [$id => $avg],['countRate' => $jumlahOrgReview] ]);
        

        $items_show = Adfood_reservation::with([
            'merchant','merchant_lengkap','customer','customer_lengkap'
        ])
        ->where('acc',0)
        ->where(function ($query) use ($id) {
            $query->where('adfood_merchants_id',$id)
                    ->orWhere('adfood_customers_id',$id);
            })
        ->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'success'         => true,
            'avgNcountRate'   => $hasil_avg,
            'item'            => $items_show,
            ], 200);

        // return view('pages.admin.reservations-adfood.detail', [
        //     'item' => $item
        // ]);
    }

    public function showbymerchantcustomerhistori($id)
    {
        $items = Adfood_reservation::with([
            'merchant','merchant_lengkap','customer','customer_lengkap'
        ])
        ->where('adfood_merchants_id',$id)
        ->orWhere('adfood_customers_id',$id)
        ->get();


        $count = $items->where('rate',!null)->count();
        $sum = $items->where('rate',!null)->sum('rate');


        if ($count != 0) {
            $jumlahOrgReview = $count;
            $hasilrete =$sum;
            $avg = $hasilrete/$jumlahOrgReview;
        } else {
            $jumlahOrgReview = 0;
            $avg = 0;
        }
            
        $jumlahOrgReview = $count;
        $hasilrete =$sum;
        $hasil_avg = collect([ [$id => $avg],['countRate' => $jumlahOrgReview] ]);

        $items_show = Adfood_reservation::with([
            'merchant','merchant_lengkap','customer','customer_lengkap'
        ])
        ->where('acc',1)
        ->where(function ($query) use ($id) {
            $query->where('adfood_merchants_id',$id)
                    ->orWhere('adfood_customers_id',$id);
            })
        ->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'success'         => true,
            'avgNcountRate'   => $hasil_avg,
            'item'            => $items_show,
            ], 200);

        // return view('pages.admin.reservations-adfood.detail', [
        //     'item' => $item
        // ]);
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Adfood_reservation::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-reservations.index');
    }

    public function history()
    {

        $items_history = Adfood_reservation::with([
            'merchant','customer'
        ])
        ->where('acc',1)
        ->orderBy('created_at', 'desc')
        ->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            
            $items = Adfood_reservation::with([
                'merchant','customer','merchant_lengkap'
            ])
            // ->where('acc',!1)
            // ->where('rate', '!=', null)
            ->where(function ($query) {
                $query->where('adfood_merchants_id','!=', null)
                        ->orWhere('adfood_customers_id','!=', null);
                })
            ->orderBy('created_at', 'desc')
            ->get();
            

            // memisahkan utk avg
            $rate_users = $items->whereIn('rate',!null); 

            //mengambil id merchants di table reservations tanpa duplikat/unique
            $id_merchants = $rate_users->pluck('adfood_merchants_id')->unique(); 
            $id_customers = $rate_users->pluck('adfood_customers_id')->unique();
            $mergeIdCustMerch = $id_customers->merge($id_merchants); //merge  id merchant & customers yg memiliki rate
            
            //mengambil avg cust & merch, kemudian menghitung avg nya
            $hasil_avg = [];

            foreach ($mergeIdCustMerch as $id) {

                $count = $rate_users->where('adfood_merchants_id', $id )->count(); //menyaring id merchant
                if ($count == null) { //jika null id merchant,
                    $count = $rate_users->where('adfood_customers_id', $id )->count(); //tampilkan id customer
                }

                $sum = $rate_users->where('adfood_merchants_id', $id )->sum('rate'); //menyaring id merchant
                if ($sum == null) { //jika null id merchant,
                    $sum = $rate_users->where('adfood_customers_id', $id )->sum('rate'); //tampilkan id customer
                }

                $jumlahOrgReview = $count;
                $hasilrete =$sum;
                $avg = $hasilrete/$jumlahOrgReview;
                $hasil_avg[] = collect([ [$id => $avg],['countRate' => $jumlahOrgReview] ]);
                
            }

            return response()->json([
                'success'         => true,
                'avgNcountRate'   => $hasil_avg,
                'history'         => $items_history,
                ], 200);
        }
        
        


        return view('pages.admin.reservations-adfood.index', [
            'items' => $items_history
        ]);
    }

    public function scoreedit($id)
    {
        $item = Adfood_reservation::findOrFail($id);
        return view('pages.admin.reservations-adfood.rate', [
            'item' => $item
        ]);
    }

    public function scoreupdate(Request $request, $id)
    {
        $data = $request->all();
        $data['date_rate'] = \Carbon\Carbon::now();
        
        try {
            $item = Adfood_reservation::findOrFail($id);
            
            if ($request->file('pothos_coment') != null) {
                $data['pothos_coment'] = $request->file('pothos_coment')->store('assets/gallery', 'public');
                if(File::exists(('storage/'.$item->foto))){
                    File::delete('storage/'.$item->foto);            
                }
            }

            // $request->file('pothos_coment') != null ? $data['pothos_coment'] = $request->file('pothos_coment')->store('assets/gallery', 'public') : $data['pothos_coment'] = null;

            $item->update($data);
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item
                    // 'status' => $sell_properties
                ], 401);
            }
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Diupdate score',
                'data' => $item
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('Score Reservation', $item->order_id.' Successfully Updated');     
        
        return redirect()->route('reservations_history');
    }

    public function notifikasiapi($id)
    {

        $item_orders = Adfood_reservation::with([
            'merchant','customer'
        ])
            ->where('acc',!1)
            ->where(function ($query) use ($id) {
            $query->where('adfood_merchants_id',$id)
                    ->orWhere('adfood_customers_id',$id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Notifikasi ',
                    'data'    => $item_orders,
                    ], 200);
            }
        // return view('pages.admin.appointments-ongoing.score-create',[
        //     'item' => $item
        // ]);
        // dd($item);
    }

    public function profile($id)
    {
        $reservation = Adfood_reservation::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'reservation', 'groomer'
            ])->where('reservations_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $reservation
                    ], 200);
            }

        return view('pages.admin.profile-reservation', [
            'reservation' => $reservation,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'reservation', 'groomer'
        //     ])
        //     ->where('ongoings.reservations_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'reservation', 'groomer'
            ])->where('reservations_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-reservation', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'reservation', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'reservation', 'groomer'
            ])->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();
            

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Invoice'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.invoice-reservation', [
            'items' => $items
        ]);
                
    }
}
