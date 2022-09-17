<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coolze_address;
use App\Users;
use App\Ongoing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AddressRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Coolze_address::with([
            'partner','customer',
        ])
        ->get();
        // dd($items);
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Address',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.addresses-coolze.index', [
            'items'          => $items,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $items_customers = Users::where('customers_id','!=', null)->where('status',1 )->get();
        $items_partners = Users::where('partners_id','!=', null)->where('status',1 )->get();
        return view('pages.admin.addresses-coolze.create',[
            'items_customers'    => $items_customers,
            'items_partners'    => $items_partners,
        ]);
    }

    public function createbyid($id)
    {   
        $item = Users::where('customers_id',$id)
        ->OrWhere('partners_id',$id)
        ->get();
        
        return view('pages.admin.addresses-coolze.createbyid',[
            'item'    => $item,
            
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $data = $request->all();
        try {
            
            
            if ($request->alamat_utama == 'on') {
                if ($request->customers_id != null || $request->customers_id != 0) {
                    Coolze_address::where('customers_id',$request->customers_id)
                        ->where('alamat_utama', 'on')
                        ->update([
                        'alamat_utama'=>null
                    ]);
                }elseif($request->partners_id != null || $request->partners_id != 0){
                    Coolze_address::where('partners_id',$request->partners_id)
                        ->where('alamat_utama', 'on')
                        ->update([
                        'alamat_utama'=>null
                    ]);
                }
                
            }
            $item = Coolze_address::create($data);
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
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Address',
                'data' => $item
            ], 200);           
        }
        // Alert::success('Address Ditambahkan', $item->title.' berhasil ditambahkan');        
        Alert::success('Address Berhasil Ditambahkan'); 
        if($request->partners_id){
            return redirect()->route('partners.index');
        }else{    
            return redirect()->route('customers.index');        
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
        $items = Coolze_address::with([
            'partner','customer',
        ])->where('customers_id',$id)
        ->OrWhere('partners_id',$id)
        ->get();
        
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Address ',
                'data' => $items
                ], 200);
        }
        
        return view('pages.admin.addresses-coolze.show', [
            'id_address'     => $id,
            'items'          => $items,
            
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
        $item = Coolze_address::findOrFail($id);

        return view('pages.admin.addresses-coolze.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        $data = $request->all();
        // dd($data);
        
        // dd($request->alamat_utama);
        
        try {

            $item = Coolze_address::findOrFail($id);
            if ($request->alamat_utama == 'on') {
                if ($item->customers_id != null || $item->customers_id != 0) {
                    Coolze_address::where('customers_id',$item->customers_id)
                    ->where('alamat_utama', 'on')
                        ->update([
                        'alamat_utama'=>null
                    ]);
                }elseif($item->partners_id != null || $item->partners_id != 0){
                    Coolze_address::where('partners_id',$item->partners_id)
                        ->where('alamat_utama', 'on')
                        ->update([
                        'alamat_utama'=>null
                    ]);
                }
            }
            
            $item_new = Coolze_address::findOrFail($id);
            $data['alamat_utama'] = $request->alamat_utama ;
            $item_new->update($data);
            // $item->update(['alamat_utama' => $data['alamat_utama']]);
            
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    // 'data' => $item
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
        // Alert::success('Address Diupdate', $item->title.' berhasil diupdate');           
        Alert::success('Address Berhasil Diupdate');           
        if($item->partners_id){
            return redirect()->route('partners.index');
        }else{    
            return redirect()->route('customers.index');        
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
        $item = Coolze_address::findOrFail($id);
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        // Alert::success('Address Dihapus', $item->title.' berhasil dihapus');        
        Alert::success('Address Berhasil Dihapus'); 
        if($item->partners_id){
            return redirect()->route('partners.index');
        }else{    
            return redirect()->route('customers.index');        
        } 
        return redirect()->route('addresses.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Address::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-addresses.index');
    }

    public function profile($id)
    {
        $address = Address::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'address', 'groomer'
            ])->where('addresss_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $address
                    ], 200);
            }

        return view('pages.admin.profile-address', [
            'address' => $address,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'address', 'groomer'
        //     ])
        //     ->where('ongoings.addresss_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'address', 'groomer'
            ])->where('addresss_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-address', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'address', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'address', 'groomer'
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
            
        return view('pages.admin.invoice-address', [
            'items' => $items
        ]);
                
    }
}
