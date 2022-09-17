<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Users;
use App\Adfood_subscriptions_merchant;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\SubscriptionsmerchantRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Subscriptionsmerchant_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Adfood_subscriptions_merchant::with([
            'merchant','merchant_lengkap','gallerymerchant', 'subscription'
            ])->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'data'                  => $items,
            ], 200);         
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.favorite-coolze.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionsmerchantRequest $request)
    {
        $data = $request->all();
        
        try {
            $item = Adfood_subscriptions_merchant::create($data);
            // dd($item);
        } catch (QueryException $e) {
            
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $e
                ], 401);
            }
            
        }    
        if(\Request::segment(1) == 'api') {
            $item_new = Adfood_subscriptions_merchant::with([
                'merchant','merchant_lengkap','gallerymerchant', 'subscription'
                ])->where('id', $item->id)->get();
            return response([
                'success'       => True,
                'data'          => $item_new,
            ], 200);           
        }
        // Alert::success('Adfood_subscriptions_merchant Ditambahkan', $item->title.' berhasil ditambahkan');        
        // return redirect()->route('favorite.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Adfood_subscriptions_merchant::with([
            'merchant','merchant_lengkap','gallerymerchant', 'subscription'
            ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'item'                  => $item,
            ], 200);         
        }

        return view('pages.admin.favorite.detail', [
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
        $item = Adfood_subscriptions_merchant::findOrFail($id);

        return view('pages.admin.favorite-coolze.edit', [
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
    public function update(SubscriptionsmerchantRequest $request, $id)
    {
        $data = $request->all();

        try {
            $item = Adfood_subscriptions_merchant::findOrFail($id);
            $item->update($data);
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $e
                    // 'status' => $sell_properties
                ], 401);
            }
            
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            $item_new = Adfood_subscriptions_merchant::with([
                'merchant','merchant_lengkap','gallerymerchant', 'subscription'
                ])->where('id', $item->id)->get();
            return response([
                'success'       => True,
                'item'           => $item_new,
            ], 200);           
        }
        Alert::success('Adfood_subscriptions_merchant Diupdate', $item->title.' berhasil diupdate');           
        return redirect()->route('favorite.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Adfood_subscriptions_merchant::findOrFail($id);
        //delete image
        if(File::exists(('storage/'.$item->url))){
            File::delete('storage/'.$item->url);            
        }
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success' => True,
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        Alert::success('Adfood_subscriptions_merchant Dihapus', $item->title.' berhasil dihapus');        
        return redirect()->route('favorite.index');
    }

    public function destroy_permanen($id)
    {
        $item = Adfood_subscriptions_merchant::with([
            'merchant','merchant_lengkap','gallerymerchant', 'subscription'
            ])->findOrFail($id);

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'       => True,
                'data'          => $item
                
            ], 200);           
        }
        // Alert::success('Merchant ', $item->name.' Successfully Delete');        
        // return redirect()->route('merchants.index');
    }

    public function show_id_merchant($id)
    {
        $item = Adfood_subscriptions_merchant::with([
            'merchant','merchant_lengkap','gallerymerchant', 'subscription'
            ])->where('merchants_id',$id)
            ->get();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'data'                  => $item,
            ], 200);         
        }

        return view('pages.admin.favorite.detail', [
            'item' => $item
        ]);
    }

    public function show_id_subscription($id)
    {
        $item = Adfood_subscriptions_merchant::with([
            'merchant','merchant_lengkap','gallerymerchant', 'subscription'
            ])->where('subscriptions_id',$id)
            ->get();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'data'                  => $item,
            ], 200);         
        }

        return view('pages.admin.favorite.detail', [
            'item' => $item
        ]);
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Adfood_subscriptions_merchant::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-favorite.index');
    }


    
    

    public function profile($id)
    {
        $favorite = Adfood_subscriptions_merchant::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'favorite', 'groomer'
            ])->where('favorites_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $favorite
                    ], 200);
            }

        return view('pages.admin.profile-favorite', [
            'favorite' => $favorite,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'favorite', 'groomer'
        //     ])
        //     ->where('ongoings.favorites_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'favorite', 'groomer'
            ])->where('favorites_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-favorite', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'favorite', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'favorite', 'groomer'
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
            
        return view('pages.admin.invoice-favorite', [
            'items' => $items
        ]);
                
    }
}
