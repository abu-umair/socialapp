<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ongoing;
use App\Customer;
use App\Doctor;
use App\Groomer;
use App\Service;
use App\Http\Requests\Admin\HistoryRequest;
use Illuminate\Support\Facades\Auth;
use Alert;
use Carbon\Carbon;
use Hamcrest\Core\IsNot;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HistoriController extends Controller
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
        // ->where('acc', '!=', null)
        // ->get();
        // // $items = Ongoing::with([
        // //     'customer', 'doctor', 'groomer'
        // //     ])->where('acc', '!=', null)->get();


        //     if(\Request::segment(1) == 'api') {
        //         return response()->json([
        //             'success' => true,
        //             'message' => 'List Semua History',
        //             'data' => $items
        //             ], 200);
        //     }
        $items = Ongoing::with([
            'user','customer', 'doctor', 'groomer'
            ])
            ->where('acc', '!=', null)
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
                    'message' => 'List Semua History',
                    'data' => $items,
                    // 'data doctor' => $item_doctor,
                    // 'data groomer' => $item_groomer
                    ], 200);
            }

        return view('pages.admin.appointments-history.index', [
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
        return view('pages.admin.appointments-history.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoryRequest $request)
    {
        $data = $request->all(); 
        $data['acc'] = $data['acc'] == 0 ? null : Carbon::now();
        try {
            $item = Ongoing::with(['customer', 'doctor', 'groomer'])->create($data);

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
                'message' => 'Berhasil Disimpan History',
                'data' => $$item
            ], 200);           
        }
        Alert::success('History Ditambahkan', $item->name.' berhasil ditambahkan');                         
        return redirect()->route('services-history.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        // $a = 'acc'='1';
        $item = Ongoing::with([
            'customer', 'doctor', 'groomer'
            ])->where('id', $id)
            ->where('acc', '!=', null)
            ->firstOrFail();
        // ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get History CUstomer : '.$item->customer->name,
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
        $item = Ongoing::with(['customer', 'doctor', 'groomer'])->findOrFail($id);
        $customers = Customer::all();
        $doctors = Doctor::all();
        $groomers = Groomer::all();
        return view('pages.admin.appointments-history.edit', [
            'item' => $item,
            'customers' => $customers,
            'doctors' => $doctors,
            'groomers' => $groomers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HistoryRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        $data['acc'] = $data['acc'] == 0 ? null : Carbon::now();

        $item = Ongoing::with(['customer', 'doctor', 'groomer'])->findOrFail($id);
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
                'message' => 'Berhasil Diupdate',
                'data' => $item
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('History Diupdate', $item->name.' berhasil diupdate');                   
        return redirect()->route('appointments-history.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Ongoing::with(['customer', 'doctor', 'groomer'])->find($id);
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete History, Customer : '.$item->customer->name,
                'data' => $item
            ], 200);
        }

        Alert::success('History Didelete', $item->name.' berhasil didelete');         
        return redirect()->route('appointments-history.index');
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
        return redirect()->route('services-history.index');
    }

    public function showhistoriuser()
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
            ->where('acc', '!=', null)
            ->orderBy('created_at', 'DESC')
            ->get();
        // ->findOrFail($id);

        foreach ($items as $item) {
            $collection = $item;
        }
        
        if ($items) {
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'Get Histories yang CUstomer sedang login : '.$item->user->name,
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
