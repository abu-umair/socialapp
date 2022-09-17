<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Coolze_address;
use App\Coolze_package;
use App\Ongoing;
use App\Users;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\OrderRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use App\Coolze_customer;
use App\Coolze_driver;
use App\Coolze_partner;
use App\Coolze_order;
use App\Coolze_subpackage;
use App\Coolze_voucher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
        ])
        ->where('acc',!1)
        // TODO: menambahkan orderBy di order partner, dan user (api)
        ->orderBy('created_at', 'desc')
        ->get();
        
        
        // $user= Auth::user()->roles;
            // dd($items);
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Orders',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.orders-coolze.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $items_customers = Users::with([
            'customer'
        ])
        ->where('customers_id','!=', null)
        ->where('status', 1)
        ->get();

        $items_partners = Users::with([
            'partner','driver',
            ])
            ->where('partners_id','!=', null)
            ->where('status', 1)
            ->get();
        $items_vouchers = Coolze_voucher::where('status', 1)
        ->get();
        $items_packages = Coolze_package::with([
            'subpackage'
        ])
            ->where('status', 1)
            ->get();
        
        return view('pages.admin.orders-coolze.create',[
            'items_customers'    => $items_customers,
            'items_partners'    => $items_partners,
            'items_vouchers'    => $items_vouchers,
            'items_packages'    => $items_packages,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $data = $request->all();
        $data['acc'] = $request->status == 'pending' ? 0 : 1 ;
        $data['id_unique'] = uniqid();
        try {
            $item = Coolze_order::create($data);
            // dd($item);
        } catch (QueryException $e) {
            
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item
                ], 401);
            }
            return back()->with('error', 'Error Create');
        }    
        if(\Request::segment(1) == 'api') {
            // kirim notifications table
            $items_customers = Users::findOrFail($data['customers_id']);
            $toDatabase = Coolze_order::where('id',$item->id)->get(); 
            $enrollmentData = [
                'description'         => 'New Order ',
                'from'                => $items_customers->name,
                'partners_id'         => $request->partners_id,
            ];
            // $toDatabase->notify(new InvoicePaid($enrollmentData));
            Notification::send($toDatabase, new InvoicePaid($enrollmentData));
            // kirim notifications table
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Order',
                'data' => $item
            ], 200);           
        }

        // kirim notifications table
        $items_customers = Users::findOrFail($data['customers_id']);
        $toDatabase = Coolze_order::where('id',$item->id)->get(); 
            $enrollmentData = [
                'description'         => 'New Order ',
                'from'                => $items_customers->name,
                'partners_id'         => $request->partners_id,
            ];
            // $toDatabase->notify(new InvoicePaid($enrollmentData));
            Notification::send($toDatabase, new InvoicePaid($enrollmentData));
        // kirim notifications table

        // Alert::success('Order Ditambahkan', $item->title.' berhasil ditambahkan');        
        Alert::success('Order Berhasil Ditambahkan');
        if ($item->acc == 1) {
            return redirect()->route('history-orders');
        } else {
            return redirect()->route('orders.index');
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
        $item = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
        ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Order '.$item->title,
                'data' => $item
                ], 200);
        }

        return view('pages.admin.orders.detail', [
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
        
        $item = Coolze_order::with([
            'customer','user_customer','partner','user_partner','driver','voucher','package','subpackage'
        ])->findOrFail($id);

        $items_customers = Users::with([
            'customer'
        ])
        ->where('customers_id','!=', null)
        ->where('status', 1)
        ->get();

        $items_partners = Users::with([
            'partner','driver',
            ])
            ->where('partners_id','!=', null)
            ->where('status', 1)
            ->get();

        $items_vouchers = Coolze_voucher::where('status', 1)
            ->get();
        $items_packages = Coolze_package::with([
            'subpackage'
        ])
            ->where('status', 1)
            ->get();
        
        return view('pages.admin.orders-coolze.edit',[
            'item'              => $item,
            'items_customers'   => $items_customers,
            'items_partners'    => $items_partners,
            'items_vouchers'    => $items_vouchers,
            'items_packages'    => $items_packages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        $data = $request->all();
        $data['acc'] = $request->status == 'pending' ? 0 : 1 ;
        $data['created_at']= \Carbon\Carbon::now();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        $item = Coolze_order::findOrFail($id);
        try {
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
                'message' => 'Berhasil Diedit',
                'data' => $item
                // 'status' => $sell_properties
            ], 200);
        }
        // Alert::success('Order Diupdate', $item->title.' berhasil diupdate');     
        Alert::success('Order Berhasil Diupdate');
        if ($item->acc == 1) {
            return redirect()->route('history-orders');
        } else {
            return redirect()->route('orders.index');
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
        $item = Coolze_order::findOrFail($id);
        
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        Alert::success('Order Berhasil Dihapus');        
        return redirect()->route('orders.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Coolze_order::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-orders.index');
    }

    public function history()
    {
        $items = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
        ])->where('acc',1)->get();
        // $user= Auth::user()->roles;
            // dd($items);
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua History Orders',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.ordershistory-coolze.index', [
            'items' => $items
        ]);
    }

    public function scoreedit($id)
    {
        $item = Coolze_order::findOrFail($id);
        return view('pages.admin.ordershistory-coolze.edit', [
            'item' => $item
        ]);
    }

    public function scoreupdate(Request $request, $id)
    {
        $data = $request->all();
        $data['isreviewed'] = 1;
        $item = Coolze_order::findOrFail($id);
        try {
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
        Alert::success('Score Diupdate', $item->rate.' berhasil diupdate');     
        
        return redirect()->route('history-orders');
    }

    public function notifikasiapi()
    {

        $item_orders = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
        ])
            ->where('acc',!1)
            ->orderBy('created_at', 'desc')
            ->get();

        $item_histori = Coolze_order::with([
                'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
            ])
            ->where('acc',1)
            ->orderBy('created_at', 'desc')
            ->get();

        
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Notifikasi ',
                    'data orders / belum acc' => $item_orders,
                    'data history / acc' => $item_histori,
                    ], 200);
            }
        // return view('pages.admin.appointments-ongoing.score-create',[
        //     'item' => $item
        // ]);
        // dd($item);
    }
    
    public function showorderuser()
    {
        $user= Auth::user()->id;

        $userlogin = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
                ])
                    ->where('acc',!1 )
                    ->where('customers_id',$user)
                    ->OrWhere('partners_id',$user)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        
        if(\Request::segment(1) == 'api') {
                    return response()->json([
                        'success' => true,
                        'message' => 'Get Orders User Login : ',
                        'data' => $userlogin
                        ], 200);
        }
        
    }

    public function showhistoriuser()
    {
        $user= Auth::user()->id;

        $userlogin = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
                ])
                    ->where('acc',1)
                    ->where('customers_id',$user)
                    ->OrWhere('partners_id',$user)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        
        if(\Request::segment(1) == 'api') {
                    return response()->json([
                        'success' => true,
                        'message' => 'Get Histori Orders User Login: ',
                        'data' => $userlogin
                        ], 200);
                }
    }

    public function stardriver()
    {
        $items = Coolze_driver::all();

        $rateconvert = [];
        $jmlhcal = [];
        $coment = [];
        $idDriver = [];
        $grouped = [];
        $name_driver = [];

        foreach ($items as $value) {
            
            $a = Coolze_order::with(['driver'])->where('drivers_id',$value->id)->where('acc',1)->get();
            $jumlahOrgReview = $a->count();
            
            if($a->count()){ 
                if ($a->count() > 1) {
                    foreach ($a as $key) {
                        $jmlhcal[]=$key->rate;            
                        $coment[]=$key->ulasan_rate;            //bagus 
                        $idDriver[]=$key->drivers_id; 
                        $name_driver[] = $key->driver->name;
                    }
                    // mendapatkan calculating rate
                    $hasilrete = array_sum($jmlhcal);//menjumlahkan pada array
                    // $rateconvert[] = $hasilrete/$jumlahOrgReview;
                    
                    // mendapatkan nilai driver id, name, ulasan dan rate
                    $collection = collect([
                        ['drivers_id' => $idDriver[0], 
                        'name_driver' => $name_driver[0],
                        'avg'   => $hasilrete/$jumlahOrgReview,
                        'ulasan' => $coment,
                        'rate' => $jmlhcal],
                    ]);


                    

                    // mendapatkan nilai driver id, name, ulasan dan rate
                    $grouped[] = $collection->groupBy('drivers_id');
                    // $grouped->all();
                    
                    
                    
                }else {
                    // mendapatkan calculating rate
                    $hasilrete = $a[0]->rate;
                    // $rateconvert[] = $hasilrete / $jumlahOrgReview;
                    // $selected[]= $a[0]->rate;

                    // mendapatkan nilai driver id, name, ulasan dan rate
                    $collection = collect([
                        ['drivers_id' => $a[0]->drivers_id,
                        'name_driver' => $a[0]->driver->name,
                        'avg'   => $hasilrete/$jumlahOrgReview,
                        'ulasan' =>  $a[0]->ulasan_rate,
                        'rate' =>  $a[0]->rate]
                    ]);

                    // mendapatkan nilai driver id, name, ulasan dan rate
                    $grouped[] = $collection->groupBy('drivers_id');
                    // $grouped->all();
                   

                    
                }
                
                
            }
        }
        //dd($grouped); //tampilkan name, id driver, rate msing2 dan ulasan masing2
        
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Driver Avg, Rate & Coment',
                'data' => $grouped
                ], 200);
        }

        
    }

    public function profile($id)
    {
        $order = Coolze_order::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'order', 'groomer'
            ])->where('orders_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $order
                    ], 200);
            }

        return view('pages.admin.profile-order', [
            'order' => $order,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'order', 'groomer'
        //     ])
        //     ->where('ongoings.orders_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'order', 'groomer'
            ])->where('orders_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-order', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'order', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'order', 'groomer'
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
            
        return view('pages.admin.invoice-order', [
            'items' => $items
        ]);
                
    }
    // subpackages
    public function subpackages($id){
        // $result_explode = explode('|', $id);
        // $valueOne= $result_explode[0]; //output 1
        // $valueTwo= $result_explode[1]; //output 2010
        echo json_encode(Coolze_subpackage::where('packages_id', $id)
                ->get());
    }
    // subdriver
    public function subdriver($id){
        // $result_explode = explode('|', $id);
        // $valueOne= $result_explode[0]; //output 1
        // $valueTwo= $result_explode[1]; //output 2010

        $driver = Coolze_driver::where('partners_id',$id)
        ->where('confirm','on')
        ->get();
        
        echo json_encode($driver);
    }
}
