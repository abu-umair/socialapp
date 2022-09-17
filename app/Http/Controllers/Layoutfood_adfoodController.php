<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Adfood_customer;
use App\Adfood_merchant;
use App\Adfood_food;
use App\Adfood_galleries_food;
use App\Coolze_customer;
use App\Coolze_partner;
use App\Ongoing;
use App\User;
use App\Users;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\FoodRequest;
use Illuminate\Support\Facades\Hash;
use Alert;
use App\Adfood_category;
use App\Coolze_order;
use App\Coolze_package;
use App\Coolze_voucher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Layoutfood_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Adfood_food::with([
            'merchant','merchant_lengkap','category','gallery'
            ])
            // ->where('status', 1)
            ->has('merchant_lengkap')// merchant tidak null 
            ->orderBy('order', 'asc')
            ->get();
        
            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Layout Food',
                    'data' => $posts
                    ], 200);
            }
        
        return view('pages.admin.layoutfoods-adfood.index', [
            'posts' => $posts,
            
        ]);
    }

    public function layoutfoodsortable(Request $request)
    {
        $posts = Adfood_food::all();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Adfood_category::all();
        $merchants = Users::with([
            'merchant'
            ])
            ->where('merchants_id','!=', null)
            ->where('status', 1)
            ->get();
            
        return view('pages.admin.foods-adfood.create', [
            'merchants' => $merchants,
            'categories'=> $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        $data = $request->all();
        // dd($data);
        try {
            $this->validate($request, [
                'foto' => 'required',
                'foto.*' => 'mimes:jpeg,bmp,png',
            ]);

            $item = Adfood_food::create([
                // 'foto'              => json_encode($dataUploadname),
                'name'              => $data['name'],
                'categories_id'     => $data['categories_id'],
                'price'             => $data['price'],
                'promo'             => $data['promo'],
                'status'            => $data['status'],
                'merchants_id'      => $data['merchants_id'],                
            ]);

            $urutan = 1;
            if($request->hasfile('foto'))
            {
               foreach($request->file('foto') as $file)
               {
                   $name = uniqid() .'.'.$file->extension();
                   $file->move(public_path().'/storage/assets/multipleimage/', $name);  
                   $dataUploadname[] = $name;

                    $file= new Adfood_galleries_food();
                    $file->foto=$name;
                    $file->adfood_foods_id=$item->id;
                    $file->urutan=$urutan++;
                    $file->save();
                   
               }
            }

        } catch (QueryException $e) {
            

            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $e,
                ], 401);
            }

            return back()->with('error', 'Error Create');
            // return back()->with('error', 'Error Create');
        }    

        if(\Request::segment(1) == 'api') {
            $item_new = Adfood_food::with([
                'merchant','user','category','gallery',
            ])->where('id', $item->id)->get();
            return response()->json([
                'id'            => $item_new->first()->id,
                'name'          => $item_new->first()->name,
                'foto'          => $item_new->first()->gallery->sortBy('urutan'),
                'price'         => $item_new->first()->price,
                'promo'         => $item_new->first()->promo,
                'status'        => $item_new->first()->status,
                'category'      => $item_new->first()->category->first()->category,
                'category_foto' => $item_new->first()->category->first()->foto,
                'merchants_name'=> $item_new->first()->user->first()->name,
                'email'         => $item_new->first()->user->first()->email,
                'phone'         => $item_new->first()->user->first()->phone,
                'merchants_foto'=> $item_new->first()->user->first()->foto,
                'merchants_id'  => $item_new->first()->merchants_id,
                ], 200);        
        }
        Alert::success('Food ', $request->name.' Successfully Create');           
        return redirect()->route('foods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Adfood_food::with([
            'merchant','user','category','gallery'
            ])
        ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            // return response()->json([
            //     'data'            => $item->user->shift(),
                
            //     ], 200);
            return response()->json([
                'id'            => $item->id,
                'name'          => $item->name,
                'foto'          => $item->gallery->sortBy('urutan'),
                'price'         => $item->price,
                'promo'         => $item->promo,
                'status'        => $item->status,
                'category'      => $item->category->first()->category,
                'category_foto' => $item->category->first()->foto,
                'merchants_name'=> $item->user->first()->name,
                'email'         => $item->user->first()->email,
                'phone'         => $item->user->first()->phone,
                'merchants_foto'=> $item->user->first()->foto,
                'merchants_id'  => $item->merchants_id,
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
        $categories = Adfood_category::all();
        $item = Adfood_food::with([
            'merchant','user','category','gallery'
        ])->findOrFail($id);
        
        // $merchants = Users::with([
        //     'merchant'
        //     ])
        //     ->where('merchants_id',$item->merchants_id)
        //     ->where('status', 1)
        //     ->get();

            $merchants = Users::with([
                'merchant'
                ])
                ->where('merchants_id','!=', null)
                ->where('status', 1)
                ->get();
            
        return view('pages.admin.foods-adfood.edit', [
            'item'     => $item,
            'merchants' => $merchants,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FoodRequest $request, $id)
    {
        $this->validate($request, [
            // 'foto' => 'required',
            'foto.*' => 'mimes:jpeg,bmp,png',
        ]);

        $item = Adfood_food::with([
            'user'
        ])->findOrFail($id);


        // if ($request->file('foto') != null) {
        //     $path = $request->file('foto')->store('assets/gallery', 'public');
        //     //delete image
        //     if(File::exists(('storage/'.$item->foto))){
        //         File::delete('storage/'.$item->foto);            
        //     }
        // } else {
        //     $path = $item->foto;
        // }
        

        try {
            $item_user = $item->update([
                    // 'foto'         => $path,
                    'name'         => $request->name,
                    'categories_id'=> $request->categories_id,
                    'price'        => $request->price,
                    'promo'        => $request->promo,
                    'status'       => $request->status,
                    'merchants_id' => $request->merchants_id,
                ]);

            $urutan = 10;
            if($request->hasfile('foto'))
            {
               foreach($request->file('foto') as $file)
               {
                   $name = uniqid() .'.'.$file->extension();
                   $file->move(public_path().'/storage/assets/multipleimage/', $name);  
                   $dataUploadname[] = $name;

                    $file= new Adfood_galleries_food();
                    $file->foto=$name;
                    $file->adfood_foods_id=$item->id;
                    $file->urutan=$urutan++;
                    $file->save();
                   
               }
            }
               
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Diupdate',
                    // 'data lengkap customer'=>$item_cust
                ], 401);
            }
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            $item_new = Adfood_food::with([
                'merchant','user','category','gallery'
            ])->findOrFail($id);

            return response([
                'id'            => $item_new->id,
                'name'          => $item_new->name,
                'foto'          => $item->gallery->sortBy('urutan'),
                'price'         => $item_new->price,
                'promo'         => $item_new->promo,
                'status'        => $item_new->status,
                'category'      => $item_new->category->first()->category,
                'category_foto' => $item_new->category->first()->foto,
                'merchants_name'=> $item_new->user->first()->name,
                'email'         => $item_new->user->first()->email,
                'phone'         => $item_new->user->first()->phone,
                'merchants_foto'=> $item_new->user->first()->foto,
                'merchants_id'  => $item_new->merchants_id,
            ], 200);
        }
        Alert::success('Food', $item->name.' Successfully Updated');            
        return redirect()->route('foods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Adfood_food::with([
            'user','merchant','category','gallery'
        ])
        ->findOrFail($id);
        // $partOrcust = Coolze_customer::findOrFail($id) ;        
        // $partOrcust = Coolze_partner::findOrFail($id);

        
        
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }

        $item->update([
            'status' => 0,
        ]);
        // $item->delete();
        // $partOrcust->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'id'            => $item->id,
                'name'          => $item->name,
                'foto'          => $item->gallery->sortBy('urutan'),
                'price'         => $item->price,
                'promo'         => $item->promo,
                'status'        => $item->status,
                'category'      => $item->category->first()->category,
                'category_foto' => $item->category->first()->foto,
                'merchants_name'=> $item->user->first()->name,
                'email'         => $item->user->first()->email,
                'phone'         => $item->user->first()->phone,
                'merchants_foto'=> $item->user->first()->foto,
                'merchants_id'  => $item->merchants_id,
            ], 200);
        }
        Alert::success('Food', $item->name.' Status Is Not Active');                
        return redirect()->route('foods.index');
    }

    public function destroy_permanen($id)
    {
        $item = Adfood_food::with([
            'user','merchant','category','gallery'
        ])
        ->findOrFail($id);
        
        //delete image multiple
        if ($item->gallery) {
            foreach ($item->gallery as $itemGallery) {
                File::delete('storage/assets/multipleimage/'.$itemGallery->foto);   
                $itemGallery->delete();
            }
        }
        
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'       => true,
                'id'            => $item->id,
                'name'          => $item->name,
                'foto'          => $item->gallery->sortBy('urutan'),
                'price'         => $item->price,
                'promo'         => $item->promo,
                'status'        => $item->status,
                'category'      => $item->category->first()->category,
                'category_foto' => $item->category->first()->foto,
                'merchants_name'=> $item->user->first()->name,
                'email'         => $item->user->first()->email,
                'phone'         => $item->user->first()->phone,
                'merchants_foto'=> $item->user->first()->foto,
                'merchants_id'  => $item->merchants_id,
            ], 200);
        }
        Alert::success('Voucher ', $item->name.' Successfully Delete');        
        return redirect()->route('merchants.index');
    }

    public function showbymerchant($id)
    {
        $item = Adfood_food::with([
            'merchant','user','category','gallery'
            ])
            ->has('merchant')
            ->where('merchants_id',$id)
            ->get();

        if(\Request::segment(1) == 'api') {
            // return response()->json([
            //     'data'            => $item->user->shift(),
                
            //     ], 200);
            return response()->json([
                'status'            => true,
                'item'              => $item,
                // 'id'            => $item->id,
                // 'name'          => $item->name,
                // 'foto'          => $item->gallery->sortBy('urutan'),
                // 'category'      => $item->category,
                // 'price'         => $item->price,
                // 'promo'         => $item->promo,
                // 'status'        => $item->status,
                // 'merchants_name'=> $item->user->first()->name,
                // 'email'         => $item->user->first()->email,
                // 'phone'         => $item->user->first()->phone,
                // 'merchants_foto'=> $item->user->first()->foto,
                // 'merchants_id'  => $item->merchants_id,
                ], 200);
        }

        return view('pages.admin.users-customer.detail', [
            'item' => $item
        ]);
        
    }

    public function indexgallery()
    {
        $items = Adfood_galleries_food::with([
            'food'
        ])
        ->orderBy('created_at', 'DESC')
        ->get();

        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Foto Food',
                'data' => $items
                ], 200);
        }
        return view('pages.admin.foods-adfood.index', [
            'items' => $items,
            
        ]);
    }

    public function showgallery($id)
    {
        $item = Adfood_galleries_food::with([
            'food'
        ])
        ->orderBy('created_at', 'DESC')
        ->findOrFail($id);

        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success'         => true,
                'message'         => 'List Id Foto Food',
                'id'              => $item->id,
                'foto'            => $item->foto,
                'urutan'          => $item->urutan,
                'adfood_foods_id' => $item->adfood_foods_id
                ], 200);
        }
        return view('pages.admin.foods-adfood.index', [
            'item' => $item,
            
        ]);
    }
    
    public function edit_image($id)
    {
        $items = Adfood_galleries_food::with([
            'food'
        ])
        ->where('adfood_foods_id', $id)
        ->get();
        
        // $merchants = Users::with([
        //     'merchant'
        //     ])
        //     ->where('merchants_id',$item->merchants_id)
        //     ->where('status', 1)
        //     ->get();
            // dd($items->first()->foto);
        return view('pages.admin.foods-adfood.image', [
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
            $gallery = Adfood_galleries_food::find($id);

            if($gallery)
            {
                $gallery->urutan = $request->input('urutan');
                $gallery->update();
                return response()->json([
                    'status'          => 200,
                    'message'         =>'Gallery Updated Successfully.',
                    'id'              => $gallery->id,
                    'foto'            => $gallery->foto,
                    'urutan'          => $gallery->urutan,
                    'adfood_foods_id' => $gallery->adfood_foods_id
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

    public function destroy_food($id)
    {
        $item = Adfood_galleries_food::with([
            'food'
        ])
        ->findOrFail($id);
        
        if(File::exists(('storage/assets/multipleimage/'.$item->foto))){
            File::delete('storage/assets/multipleimage/'.$item->foto);            
        }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'         => true,
                'id'              => $item->id,
                'foto'            => $item->foto,
                'urutan'          => $item->urutan,
                'adfood_foods_id' => $item->adfood_foods_id
                
            ], 200);
        }
        Alert::success('Image Food Successfully Delete');        
        // return redirect()->route('merchants.index');
        return back();
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Food::onlyTrashed();
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
            'partner','customer', 'order_cust','order_part','order_drive','driver','address_cust','address_mitra'
            ])->findOrFail($id);
        $all_user = Users::with([
            'partner','customer', 'order_cust','order_part','order_drive','driver','address_cust','address_mitra'
            ])->get();
        $packages = Coolze_package::with([
            'subpackage'
        ])->get();

        $vouchers = Coolze_voucher::all();
        

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Profile',
                    'data' => $user
                    ], 200);
            }

            $jmlhcal = [];
            
            if ($user->partner != null) {
                $cust_mitra_driv = $user->partner;
                $address_user = $user->address_mitra;
                $order_user = $user->order_part;
                
                // count rete
                if ($user->order_part->where('isreviewed',1)->count() > 0) {
                    //total org review
                    $rate_user = $user->order_part->where('isreviewed',1)->count(); 
                    
                    //jumlah star (mengambil star)
                    $jumlah_stars = $user->order_part;
                    foreach ($jumlah_stars as $jumlah_star) {
                        $jmlhcal[] = $jumlah_star->rate;
                    }

                    //penjumlahan
                    $type_account = array_sum($jmlhcal)/$rate_user;
                    
                } else {
                    $type_account = null;
                    
                }
                
                
            } elseif ($user->customer != null) {
                $cust_mitra_driv = $user->customer;
                $address_user = $user->address_cust;
                $order_user = $user->order_cust;

                // count rete
                if ($user->order_cust->where('isreviewed',1)->count() > 0) {
                    //total org review
                    $rate_user = $user->order_cust->where('isreviewed',1)->count(); 
                    
                    //jumlah star (mengambil star)
                    $jumlah_stars = $user->order_cust;
                    foreach ($jumlah_stars as $jumlah_star) {
                        $jmlhcal[] = $jumlah_star->rate;
                    }
                    
                    //penjumlahan
                    $type_account = array_sum($jmlhcal)/$rate_user;
                    
                } else {
                    $type_account = null;
                    
                }

            } else {
                $cust_mitra_driv = $user->driver;
                $address_user = $user->driver->alamat ? $user->driver->alamat : '' ;
                $order_user = $user->order_drive;

                // count rete
                if ($user->order_drive->where('isreviewed',1)->count() > 0) {
                    //total org review
                    $rate_user = $user->order_drive->where('isreviewed',1)->count(); 
                    
                    //jumlah star (mengambil star)
                    $jumlah_stars = $user->order_drive;
                    foreach ($jumlah_stars as $jumlah_star) {
                        $jmlhcal[] = $jumlah_star->rate;
                    }

                    //penjumlahan
                    $type_account = array_sum($jmlhcal)/$rate_user;
                    
                } else {
                    $type_account = null;
                    
                }
            }
            
            // dd($type_account);

           
            
             
        return view('pages.admin.profile-coolze.index', [
            'user'            => $user,
            'cust_mitra_driv' => $cust_mitra_driv,
            'address_user'    => $address_user,
            'order_user'      => $order_user,
            'all_user'        => $all_user,
            'packages'        => $packages,
            'vouchers'        => $vouchers,
            'type_account'    => $type_account,
        ]);
        
        
    }

    public function transaksi($id)
    {
        
        $items = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
            ])->where('foods_id', $id)
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
