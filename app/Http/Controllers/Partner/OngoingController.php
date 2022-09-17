<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Ongoing;
use App\Customer;
use App\Doctor;
use App\Groomer;
use App\User;
use App\Users;
use App\Service;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\OngoingRequest;
use Alert;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OngoingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // // ->join('services','services.id', '=','metode_layanan')
        //     ->where('acc', null)
        //     ->get();
        $items = Ongoing::with([
            'user','customer', 'doctor', 'groomer'
            ])
        ->where('acc', null)
        ->orderBy('created_at', 'DESC')
        ->get();

        

        foreach ($items as $item_lengkap) {
            $item_sempurna =$item_lengkap->user;
            
            // dd($item_lengkap);
        }
        foreach ($items as $item_doctor) {
            // $item_sempurna =$item_doctor->customer->user;
            $item_doctor =$item_doctor->doctor;
           
            // dd($item_lengkap);
        }
        foreach ($items as $item_groomer) {
            // $item_sempurna =$item_groomer->customer->user;
            $item_groomer =$item_groomer->groomer;
            
            // dd($item_lengkap);
        }
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $items,
                    // 'data doctor' => $item_doctor,
                    // 'data groomer' => $item_groomer,
                    ], 200);
            }
            // dd($items);
        return view('pages.admin.appointments-ongoing.index', [
            'items' => $items,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $customers = Users::with(['user'])->get();
        $doctors = Doctor::all();
        $groomers = Groomer::all();
        // $services = Service::all();
        return view('pages.admin.appointments-ongoing.create', [            
            'customers' => $customers,
            'doctors' => $doctors,
            'groomers' => $groomers,
            // 'services' => $services
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OngoingRequest $request)
    {
        
        $data = $request->all(); 
        $data['acc'] = $data['acc'] == 0 ? null : Carbon::now();
        $data['id_unique'] = uniqid();
        // $data['isreviewed'] = '0' ;
        try {
            // $item = Ongoing::with(['customer', 'doctor', 'groomer'])->create($data);
            $item = Ongoing::with([
                'user','customer', 'doctor', 'groomer'
                ])->create($data);
            // deklarasikan $item
            $item->customer;    
            $item->user;    
            $item->groomer;
            $item->doctor;

        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item
                ], 401);
            }
            return back()->with('error', 'Error Create ' );
            // return back()->with('error', 'Error Create');
        }    

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Ongoing',
                'data' => $item,
                // 'data groomer' => $item_groomer,
                // 'data doctor' => $item_doctor 
            ], 200);           
        }
        Alert::success('Ongoing Ditambahkan', $item->name.' berhasil ditambahkan');
        if($request->acc == 0 ){
            return redirect()->route('appointments-ongoing.index');
        }
        else{
            return redirect()->route('appointments-history.index');                         
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
        
        // $item = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        
        $item = Ongoing::with([
            'user','customer', 'doctor', 'groomer'
            ])
            // ->where('ongoings.id', $id)
            ->where('ongoings.id', $id)
            ->where('acc', null)
            ->firstOrFail();
        // ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get History CUstomer : '.$item->user->name,
                'data' => $item
                ], 200);
        }

        // return view('pages.admin.users-customer.detail', [
        //     'item' => $item
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Ongoing::select('ongoings.*')
        ->join('customers','customers.id', '=','ongoings.customers_id')
        ->join('users','users.customers_id', '=','customers.id')
        // ->join('services','services.id', '=','metode_layanan')
        // ->where('id', $id)
        ->findOrFail($id);
        // $item = Ongoing::with(['customer', 'doctor', 'groomer'])->findOrFail($id);
        $customers = Users::with(['user'])->get();
        $doctors = Doctor::all();
        $groomers = Groomer::all();
        // $services = Service::all();
        return view('pages.admin.appointments-ongoing.edit', [
            'item' => $item,
            'customers' => $customers,
            'doctors' => $doctors,
            'groomers' => $groomers,
            // 'services' => $services
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OngoingRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        $data['acc'] = $data['acc'] == 0 ? null : Carbon::now()  ;

        $item = Ongoing::with([
            'user','customer', 'doctor', 'groomer'
            ])->findOrFail($id);
        
        //fcm    
        $result = null;
        if ($data['acc'] == null && $item['acc'] != null || $data['acc'] != null && $item['acc'] == null){
                    $token = "dIOSOLQbTx8:APA91bGqb0l4SbG0EaJBmYLA-t6R4sBS05CLAZLniUtWNQYK5jvxHx-m5cmT6QtMsvf4I8_iydP3xHF0TV5fk1Lz1-16fQk6n7cL8AxrGqzJjuzi9U0pcrn2uMxZbeHxOW8W6OEFnJC-";  
                    $from = "AAAAF87ubws:APA91bEb42i_EUlOjsYyShDqZElY2pmqD1gbm4CigPKYfrnK9FPu5irDtDRtp0pyeIdg4fWpYCzXMCTlMoJwQkYmgGfeqt6wANRzSm1CZAGT33oa4hWk3IEIVtKzVuviBsLDwTP-EJ_B";
                    $msg = array    
                        (
                            'body'  => "Demo 2",
                            'title' => "Hi, From Raj",
                            'receiver' => 'erw',
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
        }
        try {
        $item->update($data);
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                
                    return response([
                        'status' => 'error',
                        'message' => 'Gagal Disimpan',
                        'data' => $item,
                        'fcm' => json_decode($result),
                        
                    ], 401);    
            }
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            
                return response([
                    'status' => 'success',
                    'message' => 'Berhasil Diupdate',
                    'data' => $item,
                    'fcm' => json_decode($result),
                ], 200);
            
            }
            
        
        Alert::success('Ongoing Diupdate', $item->name.' berhasil diupdate');
        if($request->acc == 0 ){
            return redirect()->route('appointments-ongoing.index');
        }
        else{
            return redirect()->route('appointments-history.index');                         
        }          
        return redirect()->route('appointments-ongoing.index');
    }

    
    public function destroy($id)
    {
        $item = Ongoing::with([
            'user','customer', 'doctor', 'groomer'])->findOrFail($id);
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete Ongoing, Customer : '.$item->customer->name,
                'data' => $item
            ], 200);
        }

        Alert::success('Ongoing Didelete', $item->name.' berhasil didelete'); 
        return redirect()->route('appointments-ongoing.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Ongoing::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-ongoing.index');
    }
    public function scoreCreate($id)
    {
        $item = Ongoing::with([
            'customer', 'doctor', 'groomer'])
            ->findOrFail($id);
        return view('pages.admin.appointments-ongoing.score-create',[
            'item' => $item
        ]);
    }
    public function scoreStore(Request $request, $id)
    {
        // $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        // $data['acc'] = $data['acc'] == 0 ? null : Carbon::now()  ;

        $item = Ongoing::with([
            'customer', 'doctor', 'groomer', 'user'
            ])
            ->where('acc', '!=', null)
            ->findOrFail($id);
        
        try {
            $score_store = $item->update([
                'nilai_product'          => $request->nilai_product,
                'review_product'         => $request->review_product,
                'isreviewed'         => 1
                          
            ]);
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([   
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item,
                    'status' => $score_store
                    // 'status' => $sell_properties
                ], 401);
            }
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Diupdate',
                'data' => $item,
                'status' => $score_store
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('Ongoing Diupdate', $item->name.' berhasil diupdate');
              
        return redirect()->route('appointments-history.index'); 
    }

    public function notifikasiapi()
    {
        $items_ongoing = Ongoing::with([
            'customer', 'doctor', 'groomer','user'])
            ->where('acc', null)
            ->orderBy('created_at', 'desc')
            ->get();

        $items_histori = Ongoing::with([
                'customer', 'doctor', 'groomer','user'])
                ->where('acc', !null)
                ->orderBy('created_at', 'desc')
                ->get();
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Notifikasi ',
                    'data ongoing / belum acc' => $items_ongoing,
                    'data history / acc' => $items_histori,
                    ], 200);
            }
        // return view('pages.admin.appointments-ongoing.score-create',[
        //     'item' => $item
        // ]);
        // dd($item);
    }

    public function showongoinguser()
    {
        $user= Auth::user()->customers_id;
        
        // $a = 'acc'='1';
        // $item = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        
        $items = Ongoing::with([
            'user','customer', 'doctor', 'groomer'
            ])
            // ->where('ongoings.id', $id)
            ->where('ongoings.customers_id', $user)
            ->where('acc', null)
            ->orderBy('created_at', 'DESC')
            // ->first();
        // ->findOrFail($id);
            ->get();
        
        foreach ($items as $item) {
            $collection = $item;
        }

        if ($items) {
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'Get Ongoing yang CUstomer sedang login : '.$item->user->name,
                    'data' => $items
                    ], 200);
            }
        } else {
            if(\Request::segment(1) == 'api') {
                return response([   
                    'status' => 'error',
                    'message' => 'Data Null',
                    'data' => $items,
                ], 401);
            }
        }
    }
}
