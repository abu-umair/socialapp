<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coolze_withdraw;
use App\Coolze_customer;
use App\Users;
use App\Ongoing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\WithdrawsRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Seshac\Otp\Otp;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WithdrawsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Coolze_withdraw::with([
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Withdraws',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.withdraws-coolze.index', [
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
        $items_partners = Users::where('partners_id','!=', null)
            ->where('status', 1)
            ->get();
        return view('pages.admin.withdraws-coolze.create',[
            'items_partners'    => $items_partners,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WithdrawsRequest $request)
    { //TODO: APi belum ditest, tambahkan field di create dan update withdraws (bukti_tf = foto, nominal = angka,created_at = tanggal buat)
        $data = $request->all();
        $identifier = Str::random(12);
        $otp =  Otp::setValidity(3)  // otp validity time in mins
                            ->setLength(8)  // Lenght of the generated otp
                            ->setMaximumOtpsAllowed(100) // Number of times allowed to regenerate otps
                            ->setOnlyDigits(true)  // generated otp contains mixed characters ex:ad2312
                            ->setUseSameToken(false) // if you re-generate OTP, you will get same token
                            ->generate($identifier);
        $data['id_withdraw']= 'wd-'.$otp->token;
        $request->file('bukti_tf') != null ? $data['bukti_tf'] = $request->file('bukti_tf')->store('assets/gallery', 'public') : null;
        try {
            $item = Coolze_withdraw::create($data);
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
            $item_new = Coolze_withdraw::with([
                'user'
            ])
            ->findOrFail($item->id);
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Withdraws',
                'data' => $item_new
            ], 200);           
        }
        // Alert::success('Withdraws Ditambahkan', $item->title.' berhasil ditambahkan');        
        Alert::success('Withdraws Berhasil Ditambahkan');        
        return redirect()->route('withdraws.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Coolze_withdraw::with([
            'user'
        ])->findOrFail($id);
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Withdraws ',
                'data' => $item
                ], 200);
        }

        return view('pages.admin.withdraws.detail', [
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
        $items_partners = Users::where('partners_id','!=', null)
                ->where('status', 1)    
                ->get();
                
        $item = Coolze_withdraw::with([
            'user'
        ])
        ->findOrFail($id);
            
        return view('pages.admin.withdraws-coolze.edit', [
            'item'              => $item,
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
    public function update(WithdrawsRequest $request, $id)
    {
        $data = $request->all();
        $request->file('bukti_tf') != null ? $data['bukti_tf'] = $request->file('bukti_tf')->store('assets/gallery', 'public') : null;
        $item = Coolze_withdraw::findOrFail($id);
        try {
            if ($request->file('bukti_tf') != null) {
                if(File::exists(('storage/'.$item->bukti_tf))){
                    File::delete('storage/'.$item->bukti_tf);            
                }
            }
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
        // Alert::success('Withdraws Diupdate', $item->title.' berhasil diupdate');           
        Alert::success('Withdraws Berhasil Diupdate');           
        return redirect()->route('withdraws.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Coolze_withdraw::findOrFail($id);
        
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->id_withdraw,
                'data' => $item
            ], 200);
        }
        Alert::success('Withdraws Berhasil Dihapus');        
        return redirect()->route('withdraws.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Coolze_withdraw::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-withdraws.index');
    }

    public function profile($id)
    {
        $wallets = Coolze_withdraw::findOrFail($id);
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
