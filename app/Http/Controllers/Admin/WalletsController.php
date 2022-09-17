<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coolze_wallet;
use App\Coolze_customer;
use App\Users;
use App\Ongoing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\WalletsRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Coolze_wallet::with([
            'user','user_partner'
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Wallets',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.wallets-coolze.index', [
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
        $items_customers = Users::where('customers_id','!=', null)
            ->where('status', 1)
            ->get();
        $items_partners = Users::where('partners_id','!=', null)
            ->where('status', 1)
            ->get();
        return view('pages.admin.wallets-coolze.create',[
            'items_customers'    => $items_customers,
            'items_partners'     => $items_partners,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletsRequest $request)
    {
        $data = $request->all();
        
        try {
            if ($data['customers_id'] == null & $data['partners_id'] == null) {
                return back()->with('error', 'Pilih Customer / Partners');
            }elseif ($data['customers_id'] != null & $data['partners_id'] != null) {
                return back()->with('error', 'Customer & Partners Terpilih');
            }
    
            $item = Coolze_wallet::create($data);
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
                'message' => 'Berhasil Disimpan Wallets',
                'data' => $item
            ], 200);           
        }
        // Alert::success('Wallets Ditambahkan', $item->title.' berhasil ditambahkan');        
        Alert::success('Wallets Berhasil Ditambahkan');        
        return redirect()->route('wallets.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Coolze_wallet::findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Wallets '.$item->title,
                'data' => $item
                ], 200);
        }

        return view('pages.admin.wallets.detail', [
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
        $items_customers = Users::where('customers_id','!=', null)
                ->where('status', 1)    
                ->get();
        $items_partners = Users::where('partners_id','!=', null)
                ->where('status', 1)
                ->get();
                
        $item = Coolze_wallet::with([
            'user','user_partner'
        ])
        ->where('id', $id)
        ->get();
            
        return view('pages.admin.wallets-coolze.edit', [
            'item'              => $item,
            'items_customers'  => $items_customers,
            'items_partners'  => $items_partners,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WalletsRequest $request, $id)
    {
        $data = $request->all();

        try {
            if ($data['customers_id'] == null & $data['partners_id'] == null) {
                return back()->with('error', 'Pilih Customer / Partners');
            }elseif ($data['customers_id'] != null & $data['partners_id'] != null) {
                return back()->with('error', 'Customer & Partners Terpilih');
            }
            
            $item = Coolze_wallet::findOrFail($id);
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
        // Alert::success('Wallets Diupdate', $item->title.' berhasil diupdate');           
        Alert::success('Wallets Berhasil Diupdate');           
        return redirect()->route('wallets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Coolze_wallet::findOrFail($id);
        
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        Alert::success('Wallets Berhasil Dihapus');        
        return redirect()->route('wallets.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Coolze_wallet::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-wallets.index');
    }

    public function profile($id)
    {
        $wallets = Coolze_wallet::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'wallets', 'groomer'
            ])->where('walletss_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $wallets
                    ], 200);
            }

        return view('pages.admin.profile-wallets', [
            'wallets' => $wallets,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'wallets', 'groomer'
        //     ])
        //     ->where('ongoings.walletss_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'wallets', 'groomer'
            ])->where('walletss_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-wallets', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'wallets', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'wallets', 'groomer'
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
            
        return view('pages.admin.invoice-wallets', [
            'items' => $items
        ]);
                
    }
}
