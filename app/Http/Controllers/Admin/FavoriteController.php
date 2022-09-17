<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Users;
use App\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\FavoriteRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item_new = Favorite::with([
            'merchant','merchant_lengkap','gallerymerchant', 'customer','customer_lengkap'
            ])->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'data'                  => $item_new,
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
    public function store(FavoriteRequest $request)
    {
        $data = $request->all();
        
        try {
            $item = Favorite::create($data);
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
            $item_new = Favorite::with([
                'merchant','merchant_lengkap','gallerymerchant', 'customer','customer_lengkap'
                ])->where('id', $item->id)->get();
            return response([
                'success'       => True,
                'data'          => $item_new,
                //'id_favorite'           => $item_new->first()->id,
                // 'data_merchant' => [
                //     'id'                => $item_new->first()->merchant->id,
                //     'foto'              => $item_new->first()->merchant->foto,
                //     'name'              => $item_new->first()->merchant->name,
                //     'email'             => $item_new->first()->merchant->email,
                //     'isVerified'        => $item_new->first()->merchant->isVerified,
                //     'phone'             => $item_new->first()->merchant->phone,
                //     'roles'             => $item_new->first()->merchant->roles,
                //     'status'            => $item_new->first()->merchant->status,
                //     'device_token'      => $item_new->first()->merchant->device_token,
                //     'website'           => $item_new->first()->merchant_lengkap->website,
                //     'open_restaurant'   => $item_new->first()->merchant_lengkap->open_restaurant,
                //     'close_restaurant'  => $item_new->first()->merchant_lengkap->close_restaurant,
                //     'about'             => $item_new->first()->merchant_lengkap->about,
                //     'menus_restaurant'  => $item_new->first()->gallerymerchant,
                //     'address'           => $item_new->first()->merchant_lengkap->address,
                //     'long'              => $item_new->first()->merchant_lengkap->long,
                //     'lat'               => $item_new->first()->merchant_lengkap->lat,
                // ],
                // 'data_customer' => [
                //     'id'                => $item_new->first()->customer->id,
                //     'foto'              => $item_new->first()->customer->foto,
                //     'name'              => $item_new->first()->customer->name,
                //     'email'             => $item_new->first()->customer->email,
                //     'isVerified'        => $item_new->first()->customer->isVerified,
                //     'phone'             => $item_new->first()->customer->phone,
                //     'roles'             => $item_new->first()->customer->roles,
                //     'status'            => $item_new->first()->customer->status,
                //     'device_token'      => $item_new->first()->customer->device_token,
                //     'address'           => $item_new->first()->customer_lengkap->address,
                //     'long'              => $item_new->first()->customer_lengkap->long,
                //     'lat'               => $item_new->first()->customer_lengkap->lat,
                // ],
            ], 200);           
        }
        // Alert::success('Favorite Ditambahkan', $item->title.' berhasil ditambahkan');        
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
        $item_new = Favorite::with([
            'merchant','merchant_lengkap','gallerymerchant', 'customer','customer_lengkap'
            ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'item'                  => $item_new,
                // 'id_favorite'           => $item_new->id,
                // 'data_merchant'         => [
                //     'id'                => $item_new->merchant->id,
                //     'foto'              => $item_new->merchant->foto,
                //     'name'              => $item_new->merchant->name,
                //     'email'             => $item_new->merchant->email,
                //     'isVerified'        => $item_new->merchant->isVerified,
                //     'phone'             => $item_new->merchant->phone,
                //     'roles'             => $item_new->merchant->roles,
                //     'status'            => $item_new->merchant->status,
                //     'device_token'      => $item_new->merchant->device_token,
                //     'website'           => $item_new->merchant_lengkap->website,
                //     'open_restaurant'   => $item_new->merchant_lengkap->open_restaurant,
                //     'close_restaurant'  => $item_new->merchant_lengkap->close_restaurant,
                //     'about'             => $item_new->merchant_lengkap->about,
                //     'menus_restaurant'  => $item_new->gallerymerchant,
                //     'address'           => $item_new->merchant_lengkap->address,
                //     'long'              => $item_new->merchant_lengkap->long,
                //     'lat'               => $item_new->merchant_lengkap->lat,
                // ],
                // 'data_customer' => [
                //     'id'                => $item_new->customer->id,
                //     'foto'              => $item_new->customer->foto,
                //     'name'              => $item_new->customer->name,
                //     'email'             => $item_new->customer->email,
                //     'isVerified'        => $item_new->customer->isVerified,
                //     'phone'             => $item_new->customer->phone,
                //     'roles'             => $item_new->customer->roles,
                //     'status'            => $item_new->customer->status,
                //     'device_token'      => $item_new->customer->device_token,
                //     'address'           => $item_new->customer_lengkap->address,
                //     'long'              => $item_new->customer_lengkap->long,
                //     'lat'               => $item_new->customer_lengkap->lat,
                // ],
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
        $item = Favorite::findOrFail($id);

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
    public function update(FavoriteRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        // $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : $data['foto'] = null;

        

        try {
            $item = Favorite::findOrFail($id);
            //delete image
            // if ($request->file('url') != null) {
            //     if(File::exists(('storage/'.$item->url))){
            //         File::delete('storage/'.$item->url);            
            //     }
            // }
            
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
            $item_new = Favorite::with([
                'merchant','merchant_lengkap','gallerymerchant', 'customer','customer_lengkap'
                ])->where('id', $item->id)->get();
            return response([
                'success'       => True,
                'item'           => $item_new,
                // 'id_favorite'           => $item_new->first()->id,
                // 'data_merchant' => [
                //     'id'                => $item_new->first()->merchant->id,
                //     'foto'              => $item_new->first()->merchant->foto,
                //     'name'              => $item_new->first()->merchant->name,
                //     'email'             => $item_new->first()->merchant->email,
                //     'isVerified'        => $item_new->first()->merchant->isVerified,
                //     'phone'             => $item_new->first()->merchant->phone,
                //     'roles'             => $item_new->first()->merchant->roles,
                //     'status'            => $item_new->first()->merchant->status,
                //     'device_token'      => $item_new->first()->merchant->device_token,
                //     'website'           => $item_new->first()->merchant_lengkap->website,
                //     'open_restaurant'   => $item_new->first()->merchant_lengkap->open_restaurant,
                //     'close_restaurant'  => $item_new->first()->merchant_lengkap->close_restaurant,
                //     'about'             => $item_new->first()->merchant_lengkap->about,
                //     'menus_restaurant'  => $item_new->first()->gallerymerchant,
                //     'address'           => $item_new->first()->merchant_lengkap->address,
                //     'long'              => $item_new->first()->merchant_lengkap->long,
                //     'lat'               => $item_new->first()->merchant_lengkap->lat,
                // ],
                // 'data_customer' => [
                //     'id'                => $item_new->first()->customer->id,
                //     'foto'              => $item_new->first()->customer->foto,
                //     'name'              => $item_new->first()->customer->name,
                //     'email'             => $item_new->first()->customer->email,
                //     'isVerified'        => $item_new->first()->customer->isVerified,
                //     'phone'             => $item_new->first()->customer->phone,
                //     'roles'             => $item_new->first()->customer->roles,
                //     'status'            => $item_new->first()->customer->status,
                //     'device_token'      => $item_new->first()->customer->device_token,
                //     'address'           => $item_new->first()->customer_lengkap->address,
                //     'long'              => $item_new->first()->customer_lengkap->long,
                //     'lat'               => $item_new->first()->customer_lengkap->lat,
                // ],
            ], 200);           
        }
        Alert::success('Favorite Diupdate', $item->title.' berhasil diupdate');           
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
        $item = Favorite::findOrFail($id);
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
        Alert::success('Favorite Dihapus', $item->title.' berhasil dihapus');        
        return redirect()->route('favorite.index');
    }

    public function destroy_permanen($id)
    {
        $item = Favorite::with([
            'merchant','merchant_lengkap','gallerymerchant', 'customer','customer_lengkap'
            ])->findOrFail($id);

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'       => True,
                'id_favorite'   => $item->id,
                'data'          => $item
                // 'data_merchant' => [
                //     'id'                => $item->merchant->id,
                //     'foto'              => $item->merchant->foto,
                //     'name'              => $item->merchant->name,
                //     'email'             => $item->merchant->email,
                //     'isVerified'        => $item->merchant->isVerified,
                //     'phone'             => $item->merchant->phone,
                //     'roles'             => $item->merchant->roles,
                //     'status'            => $item->merchant->status,
                //     'device_token'      => $item->merchant->device_token,
                //     'website'           => $item->merchant_lengkap->website,
                //     'open_restaurant'   => $item->merchant_lengkap->open_restaurant,
                //     'close_restaurant'  => $item->merchant_lengkap->close_restaurant,
                //     'about'             => $item->merchant_lengkap->about,
                //     'menus_restaurant'  => $item->gallerymerchant,
                //     'address'           => $item->merchant_lengkap->address,
                //     'long'              => $item->merchant_lengkap->long,
                //     'lat'               => $item->merchant_lengkap->lat,
                // ],
                // 'data_customer' => [
                //     'id'                => $item->customer->id,
                //     'foto'              => $item->customer->foto,
                //     'name'              => $item->customer->name,
                //     'email'             => $item->customer->email,
                //     'isVerified'        => $item->customer->isVerified,
                //     'phone'             => $item->customer->phone,
                //     'roles'             => $item->customer->roles,
                //     'status'            => $item->customer->status,
                //     'device_token'      => $item->customer->device_token,
                //     'address'           => $item->customer_lengkap->address,
                //     'long'              => $item->customer_lengkap->long,
                //     'lat'               => $item->customer_lengkap->lat,
                // ],
            ], 200);           
        }
        // Alert::success('Merchant ', $item->name.' Successfully Delete');        
        // return redirect()->route('merchants.index');
    }

    public function show_merchant_customer($id)
    {
        $item_new = Favorite::with([
            'merchant','merchant_lengkap','gallerymerchant', 'customer','customer_lengkap'
            ])->where('merchants_id',$id)
            ->OrWhere('customers_id',$id)
            ->get();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => True,
                'data'                  => $item_new,
            ], 200);         
        }

        return view('pages.admin.favorite.detail', [
            'item' => $item
        ]);
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Favorite::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-favorite.index');
    }


    
    

    public function profile($id)
    {
        $favorite = Favorite::findOrFail($id);
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
