<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Adfood_customer;
use App\Adfood_merchant;
use App\Coolze_customer;
use App\Adfood_galleries_merchant;
use App\Adfood_food;
use App\Users;
use App\User;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\MerchantRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Alert;
use App\Adfood_reservation;
use App\Coolze_order;
use App\Coolze_package;
use App\Coolze_voucher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Merchant_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Users::with([
            'merchant','food', 'gallerymerchant'
            ])
            ->where('merchants_id','!=', null)
            // ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'data'                => $items,
                ], 200);
        }
        //     return response()->json([
        //         'id'                => $items->first()->id,
        //         'foto'              => $items->first()->foto,
        //         'name'              => $items->first()->name,
        //         'email'             => $items->first()->email,
        //         'isVerified'        => $items->first()->isVerified,
        //         'phone'             => $items->first()->phone,
        //         'roles'             => $items->first()->roles,
        //         'status'            => $items->first()->status,
        //         'device_token'      => $items->first()->device_token,
        //         'website'           => $items->first()->merchant->website,
        //         'open_restaurant'   => $items->first()->merchant->open_restaurant,
        //         'close_restaurant'  => $items->first()->merchant->close_restaurant,
        //         'about'             => $items->first()->merchant->about,
        //         'menus_restaurant'  => $items->first()->merchant->menus_restaurant,
        //         'address'           => $items->first()->merchant->address,
        //         'long'              => $items->first()->merchant->long,
        //         'lat'               => $items->first()->merchant->lat,
        //         ], 200);
        // }
        return view('pages.admin.merchants-adfood.index', [
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
        return view('pages.admin.merchants-adfood.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MerchantRequest $request)
    {
        $request->validate([
            'email'             => 'unique:users',
            'phone'             => 'unique:users',
            // 'menus_restaurant'  => 'required',
            // 'menus_restaurant.*'=> 'mimes:jpeg,bmp,png',
        ]);

        $this->validate($request, [
            'menus_restaurant' => 'nullable',
            'menus_restaurant.*' => 'mimes:jpeg,bmp,png',
        ]);
        
        $data = $request->all();
        
        $data['password'] = Hash::make($request->password);
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : $data['foto'] = null;
        
        try {

        $item = Users::create($data);
        $item->update([
            'merchants_id'         => $item->id,
        ]);
        $item_merchant = Adfood_merchant::create([
            'id'                => $item->id,
            'min_price'         => $data['min_price'],
            'max_price'         => $data['max_price'],
            'website'           => $data['website'],
            'open_restaurant'   => $data['open_restaurant'],
            'close_restaurant'  => $data['close_restaurant'],
            'about'             => $data['about'],
            'address'           => $data['address'],
            'long'              => $data['long'],
            'lat'               => $data['lat'],
            
        ]);

        $urutan = 1;
        if($request->hasfile('menus_restaurant'))
        {
           foreach($request->file('menus_restaurant') as $file)
           {
            //    $name = uniqid() .'.'.$file->extension();
               
            //    $file->move(public_path().'/storage/assets/multipleimage/', $name);  
            // $dataUploadname[] = $name;
            
            $name = $file->store('assets/multipleimage', 'public');

                $file= new Adfood_galleries_merchant();
                $file->menus_restaurant=$name;
                $file->adfood_merchants_id=$item->id;
                $file->urutan=$urutan++;
                $file->save();
               
           }
        }
            
        } catch (QueryException $e) {
            

            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data Merchant' => $e,
                ], 401);
            }

            return back()->with('error', 'Error Create');
            // return back()->with('error', 'Error Create');
        }    

        if(\Request::segment(1) == 'api') {
            $item_new = Users::with([
                'merchant','food','gallerymerchant'
            ])->where('id', $item->id)->get();
            return response()->json([
                'id'                => $item_new->first()->id,
                'foto'              => $item_new->first()->foto,
                'name'              => $item_new->first()->name,
                'email'             => $item_new->first()->email,
                'isVerified'        => $item_new->first()->isVerified,
                'phone'             => $item_new->first()->phone,
                'day_of_birth'      => $item_new->first()->day_of_birth,
                'roles'             => $item_new->first()->roles,
                'status'            => $item_new->first()->status,
                'gender'            => $item_new->first()->gender,
                'device_token'      => $item_new->first()->device_token,
                'min_price'         => $item_new->first()->merchant->min_price,
                'max_price'         => $item_new->first()->merchant->max_price,
                'website'           => $item_new->first()->merchant->website,
                'open_restaurant'   => $item_new->first()->merchant->open_restaurant,
                'close_restaurant'  => $item_new->first()->merchant->close_restaurant,
                'about'             => $item_new->first()->merchant->about,
                'menus_restaurant'  => $item_new->first()->gallerymerchant,
                'address'           => $item_new->first()->merchant->address,
                'long'              => $item_new->first()->merchant->long,
                'lat'               => $item_new->first()->merchant->lat,
                ], 200);        
        }
        Alert::success('Merchant ', $request->name.' Successfully Create');           
        return redirect()->route('merchants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Users::with([
            'merchant','food','gallerymerchant'
            ])
        ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'id'                => $item->id,
                'foto'              => $item->foto,
                'name'              => $item->name,
                'email'             => $item->email,
                'isVerified'        => $item->isVerified,
                'phone'             => $item->phone,
                'day_of_birth'      => $item->day_of_birth,
                'roles'             => $item->roles,
                'status'            => $item->status,
                'gender'            => $item->gender,
                'device_token'      => $item->device_token,
                'min_price'         => $item->merchant->min_price,
                'max_price'         => $item->merchant->max_price,
                'website'           => $item->merchant->website,
                'open_restaurant'   => $item->merchant->open_restaurant,
                'close_restaurant'  => $item->merchant->close_restaurant,
                'about'             => $item->merchant->about,
                'menus_restaurant'  => $item->gallerymerchant,
                'address'           => $item->merchant->address,
                'long'              => $item->merchant->long,
                'lat'               => $item->merchant->lat,
                ], 200);
        }

        return view('pages.admin.users-customer.detail', [
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
        $item = Users::with([
            'merchant'
        ])->findOrFail($id);

        return view('pages.admin.merchants-adfood.edit', [
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
    public function update(MerchantRequest $request, $id)
    {
        $request->validate([
            'email'             => 'unique:users,id,'.$id,
            'phone'             => 'unique:users,id,'.$id,
            // 'menus_restaurant'  => 'required',
            // 'menus_restaurant.*'=> 'mimes:jpeg,bmp,png',
        ]);

        $this->validate($request, [
            // 'foto' => 'required',
            'menus_restaurant.*' => 'mimes:jpeg,bmp,png',
        ]);

        $item = Users::with([
            'merchant','gallerymerchant'
        ])->findOrFail($id);

        $merchant = Adfood_merchant::findOrFail($item->merchant->id);

        if ($request->file('foto') != null) {
            $path = $request->file('foto')->store('assets/gallery', 'public');
            //delete image
            if(File::exists(('storage/'.$item->foto))){
                File::delete('storage/'.$item->foto);            
            }
        } else {
            $path = $item->foto;
        }
        

        if($request->password != null && $request->password_confirmation != null){
            $pass = Hash::make($request->password);
        } else{
            $pass = $item->password;
        }
        
        try {
            $item_user = $item->update([
                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'day_of_birth' => $request->day_of_birth,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                    'status'       => $request->status,
                    'gender'       => $request->gender,
                ]);

         $item_merchant = $merchant->update([
                    'min_price'       => $request->min_price,
                    'max_price'       => $request->max_price,
                    'website'         => $request->website,
                    'about'           => $request->about,
                    'open_restaurant' => $request->open_restaurant,
                    'close_restaurant'=> $request->close_restaurant,
                    'address'         => $request->address,
                    'long'            => $request->long,
                    'lat'             => $request->lat,
                ]);       

            $urutan = 1;
            if($request->hasfile('menus_restaurant'))
            {
               foreach($request->file('menus_restaurant') as $file)
               {
                //    $name = uniqid() .'.'.$file->extension();
                //    $file->move(public_path().'/storage/assets/multipleimage/', $name);  
                //    $dataUploadname[] = $name;
                $name = $file->store('assets/multipleimage', 'public');
    
                    $file= new Adfood_galleries_merchant();
                    $file->menus_restaurant=$name;
                    $file->adfood_merchants_id=$item->id;
                    $file->urutan=$urutan++;
                    $file->save();
                   
               }
            }
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => $e,
                    // 'data lengkap customer'=>$item_cust
                ], 401);
            }
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            $item_new = Users::with([
                'merchant','food','gallerymerchant'
            ])->findOrFail($id);

            return response()->json([
                'id'                => $item_new->id,
                'foto'              => $item_new->foto,
                'name'              => $item_new->name,
                'email'             => $item_new->email,
                'isVerified'        => $item_new->isVerified,
                'phone'             => $item_new->phone,
                'day_of_birth'      => $item_new->day_of_birth,
                'roles'             => $item_new->roles,
                'status'            => $item_new->status,
                'gender'            => $item_new->gender,
                'device_token'      => $item_new->device_token,
                'min_price'         => $item_new->merchant->min_price,
                'max_price'         => $item_new->merchant->max_price,
                'website'           => $item_new->merchant->website,
                'open_restaurant'   => $item_new->merchant->open_restaurant,
                'close_restaurant'  => $item_new->merchant->close_restaurant,
                'about'             => $item_new->merchant->about,
                'menus_restaurant'  => $item_new->gallerymerchant,
                'address'           => $item_new->merchant->address,
                'long'              => $item_new->merchant->long,
                'lat'               => $item_new->merchant->lat,
                ], 200);
        }
        Alert::success('Merchant', $item->name.' Successfully Updated');            
        return redirect()->route('merchants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Users::with([
            'merchant','food','gallerymerchant'
        ])
        ->findOrFail($id);
        // $partOrcust = Coolze_customer::findOrFail($id) ;        
        // $partOrcust = Coolze_partner::findOrFail($id);

        //delete image
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }

        $item->update([
            'status' => 0,
        ]);
        // $item->delete();
        // $partOrcust->delete();

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'id'                => $item->id,
                'foto'              => $item->foto,
                'name'              => $item->name,
                'email'             => $item->email,
                'isVerified'        => $item->isVerified,
                'phone'             => $item->phone,
                'day_of_birth'      => $item->day_of_birth,
                'roles'             => $item->roles,
                'status'            => $item->status,
                'gender'            => $item->gender,
                'device_token'      => $item->device_token,
                'min_price'         => $item->merchant->min_price,
                'max_price'         => $item->merchant->max_price,
                'website'           => $item->merchant->website,
                'open_restaurant'   => $item->merchant->open_restaurant,
                'close_restaurant'  => $item->merchant->close_restaurant,
                'about'             => $item->merchant->about,
                'menus_restaurant'  => $item->gallerymerchant,
                'address'           => $item->merchant->address,
                'long'              => $item->merchant->long,
                'lat'               => $item->merchant->lat,
                ], 200);
        }
        Alert::success('Merchant', $item->name.' Status Is Not Active');                
        return redirect()->route('merchants.index');
    }

    public function destroy_permanen($id)
    {
        $item = Users::with([
            'merchant','gallerymerchant','food'
        ])
        ->findOrFail($id);

        //delete Food
        if ($item->food) {
            foreach ($item->food as $itemFood) {
                $itemFood->delete();
            }
        }

        //delete image multiple
        if ($item->gallerymerchant) {
            foreach ($item->gallerymerchant as $itemGallery) {
                File::delete('storage/'.$itemGallery->menus_restaurant);   
                $itemGallery->delete();
            }
        }

        //delete image foto
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }

        $item->merchant->delete();
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'           => true,
                'id'                => $item->id,
                'foto'              => $item->foto,
                'name'              => $item->name,
                'email'             => $item->email,
                'isVerified'        => $item->isVerified,
                'phone'             => $item->phone,
                'day_of_birth'      => $item->day_of_birth,
                'roles'             => $item->roles,
                'status'            => $item->status,
                'gender'            => $item->gender,
                'device_token'      => $item->device_token,
                'min_price'         => $item->merchant->min_price,
                'max_price'         => $item->merchant->max_price,
                'website'           => $item->merchant->website,
                'open_restaurant'   => $item->merchant->open_restaurant,
                'close_restaurant'  => $item->merchant->close_restaurant,
                'about'             => $item->merchant->about,
                'menus_restaurant'  => $item->gallerymerchant,
                'address'           => $item->merchant->address,
                'long'              => $item->merchant->long,
                'lat'               => $item->merchant->lat,
            ], 200);
        }
        Alert::success('Merchant ', $item->name.' Successfully Delete');        
        return redirect()->route('merchants.index');
    }

    public function indexgallery()
    {
        $items = Adfood_galleries_merchant::with([
            'gallerymerchant'
        ])
        ->orderBy('created_at', 'DESC')
        ->get();

        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'data' => $items
                ], 200);
        }
        
    }

    public function showgallery($id)
    {
        $item = Adfood_galleries_merchant::with([
            'gallerymerchant'
        ])
        ->orderBy('created_at', 'DESC')
        ->findOrFail($id);

        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success'             => true,
                'id'                  => $item->id,
                'menus_restaurant'    => $item->menus_restaurant,
                'urutan'              => $item->urutan,
                'adfood_merchants_id' => $item->adfood_merchants_id
                ], 200);
        }
        
    }

    public function edit_image($id)
    {
        $items = Adfood_galleries_merchant::with([
            'gallerymerchant'
        ])
        ->where('adfood_merchants_id', $id)
        ->get();
        
        // $merchants = Users::with([
        //     'merchant'
        //     ])
        //     ->where('merchants_id',$item->merchants_id)
        //     ->where('status', 1)
        //     ->get();
            // dd($items->first()->foto);
        return view('pages.admin.merchants-adfood.image', [
            'items'     => $items,
            // 'merchants' => $merchants,
        ]);
    }

    public function update_image(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'urutan'=> 'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $gallery = Adfood_galleries_merchant::find($id);

            if($gallery)
            {
                $gallery->urutan = $request->input('urutan');
                $gallery->update();
                return response()->json([
                    'status'                => 200,
                    'message'               =>'Gallery Updated Successfully.',
                    'id'                    => $gallery->id,
                    'menus_restaurant'      => $gallery->menus_restaurant,
                    'urutan'                => $gallery->urutan,
                    'adfood_merchants_id'   => $gallery->adfood_merchants_id
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Image Found.'
                ]);
            }

        }
    }

    public function destroy_menus($id)
    {
        $item = Adfood_galleries_merchant::with([
            'gallerymerchant'
        ])
        ->findOrFail($id);
        
        if(File::exists(('storage/assets/multipleimage/'.$item->menus_restaurant))){
            File::delete('storage/assets/multipleimage/'.$item->menus_restaurant);            
        }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'               => true,
                'id'                    => $item->id,
                'menus_restaurant'      => $item->menus_restaurant,
                'urutan'                => $item->urutan,
                'adfood_merchants_id'   => $item->adfood_merchants_id
                
            ], 200);
        }
        Alert::success('Image Food Successfully Delete');        
        // return redirect()->route('merchants.index');
        return back();
    }

    public function show_avg_merhant_byid($id)
    {
        
        // $items_ori = Users::join('adfood_reservations', 'users.merchants_id','=', 'adfood_reservations.adfood_merchants_id' )
        // ->where('adfood_reservations.rate','!=', null)
        // // ->where(function ($query) use ($id) {
        // //     $query->where('adfood_reservations.adfood_merchants_id',$id)
        // //             ->orWhere('adfood_reservations.adfood_customers_id',$id);
        // // })
        // // ->where('users.id',$id)
        // // ->orWhere('adfood_reservations.adfood_customers_id',$id)
        // ->orderBy('adfood_reservations.date_rate', 'desc')
        // ->get(['users.id','users.name','users.foto','adfood_reservations.rate','adfood_reservations.ulasan_rate','adfood_reservations.date_rate','adfood_reservations.pothos_coment']);

        
        try{
            $items = Adfood_reservation::with([
            'merchant' => function ($query) {
                $query->select('merchants_id','foto','name');
            },
            'customer'=> function ($query) {
                $query->select('customers_id','foto','name');
            }
            ])
            ->where('rate', '!=', null)
            ->where('adfood_merchants_id', $id)
            ->select('rate', 'date_rate', 'ulasan_rate','pothos_coment','adfood_merchants_id','adfood_customers_id')
            ->get();
            
            $total = [];
            
            foreach ($items as $item) {
                $total[] = $item->rate;
            }
            $jumlahOrgReview = count($items);
            if ($jumlahOrgReview != 0) {
                $hasilrete = array_sum($total);
                $avg = $hasilrete/$jumlahOrgReview;
                
                // $hasilll = implode(',',$total);
                // dd(array_sum($total));
                // dd(implode(',',$total));
            } else {
                $items = null;
                $jumlahOrgReview = null;
                $avg = null;

                if(\Request::segment(1) == 'api') {
                    return response([
                        'status' => false,
                        'items'         => $items,
                        'avgNcountRate' =>$jumlahOrgReview,
                        'avg'           => $avg,
                        // 'status' => $sell_properties
                    ], 401);
                }
            }
            

            
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => false,
                    'data' => $e
                    // 'status' => $sell_properties
                ], 401);
            }
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success'       => true,
                'items'         => $items,
                'avgNcountRate' =>$jumlahOrgReview,
                'avg'           => $avg,
                ], 200);
        }

        return view('pages.admin.reservations-adfood.test', [
            'items' => $items,
            'avg'   =>  $avg,
        ]);
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Merchant::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('users-customer.index');
    }

    public function profile($id)
    {
        $user = Users::with([
            'merchant','customer','food', 'gallerymerchant','reservation_merchant'
            ])->findOrFail($id);
            $jumlahOrgReview = 0;
            $avg = 0;
            $food =0;
        

            
        if ($user->merchants_id) {
            
            $food = Adfood_food::with([
                'merchant','merchant_lengkap','category','gallery'
                ])
                ->where('merchants_id',$id)
                ->get();


                $total = [];
            if ($user->reservation_merchant) {
                $user_reservation = $user->reservation_merchant->where('rate', '!=', null);
                if (count($user_reservation) != 0) {
                    foreach ($user_reservation as $item) {
                        $total[] = $item->rate;
                    }
                    $jumlahOrgReview = count($user_reservation);
                    $hasilrete = array_sum($total);
                $avg = $hasilrete/$jumlahOrgReview;
                }
                else {
                $jumlahOrgReview = 0;
                $avg = 0;
                }
            } else {
                $jumlahOrgReview = 0;
                $avg = 0;
                }
        } 
        
        
        
             
        return view('pages.admin.merchants-adfood.profile', [
            'user'                => $user,
            'food'                => $food,
            'jumlahOrgReview'     => $jumlahOrgReview,
            'avg'                 => $avg,

        ]);
    }

    public function transaksi($id)
    {
        
        $items = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
            ])->where('merchants_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-coolze.index', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        
        $item = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','driver_personal','voucher','package','subpackage'
            ])->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();    

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Invoice',
                    'data' => $item
                    ], 200);
            }
            
        return view('pages.admin.invoice-coolze.index', [
                'item' => $item
            ]);
                
    }

    public function print($id)
    {
        
        $item = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','driver_personal','voucher','package','subpackage'
            ])->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();    

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Print',
                    'data' => $item
                    ], 200);
            }
            
        return view('pages.admin.invoice-coolze.print', [
                'item' => $item
            ]);
                
    }

    
}
