<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coolze_voucher;
use App\Ongoing;
use App\User;
use App\Adfood_merchant;
use App\Adfood_galleries_voucher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\VoucherRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\True_;

class Voucher_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Coolze_voucher::with([
            'gallery','merchant'
        ])
        ->has('gallery') //gallery tidak null 
        ->has('merchant')// merchant tidak null 
        ->orderBy('created_at', 'desc')
        ->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'data' => $items
                ], 200);
        }

        return view('pages.admin.vouchers-adfood.index', [
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
        $items = User::where('merchants_id','!=',null)->get();
        return view('pages.admin.vouchers-adfood.create', [
            'items' => $items
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRequest $request)
    {
        $data = $request->all();
        if ($data['type'] == 'By One Get One') {
            $data['type'] = 11;
        }elseif($data['type'] == 'Free One Dish'){
            $data['type'] = 1;
        }

        $data['home'] = $request->home =='on'? 'on' : null ;
        $data['voucher'] = $request->voucher =='on' ? 'on' : null ;
        // $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;         
        try {
            $this->validate($request, [
                'foto' => 'required',
                'foto.*' => 'mimes:jpeg,bmp,png',
            ]);

            $item = Coolze_voucher::create($data);

            $urutan = 1;
            if($request->hasfile('foto'))
            {
               foreach($request->file('foto') as $file)
               {
                //    $name = uniqid() .'.'.$file->extension();
                //    $file->move(public_path().'/storage/assets/multipleimage/', $name);  
                //    $dataUploadname[] = $name;
                $name = $file->store('assets/multipleimage', 'public');

                    $file= new Adfood_galleries_voucher();
                    $file->foto=$name;
                    $file->vouchers_id=$item->id;
                    $file->urutan=$urutan++;
                    $file->save();
                   
               }
            }
            
        } catch (QueryException $e) {
            
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $e
                ], 401);
            }
            return back()->with('error', 'Error Create');
        }    
        if(\Request::segment(1) == 'api') {
            $item_new = Coolze_voucher::with([
                'gallery','merchant'
            ])->where('id', $item->id)->get();
            return response([
                'succes'          => True,
                'id'              => $item_new->first()->id,
                'name'            => $item_new->first()->name,
                'merchants_id'    => $item_new->first()->merchants_id,
                'name_merchant'   => $item_new->first()->merchant->name,
                'foto'            => $item_new->first()->gallery->sortBy('urutan'),
                'expired_at'      => $item_new->first()->expired_at,
                'expired_at_time' => $item_new->first()->expired_at_time,
                'coupon_code'     => $item_new->first()->coupon_code,
                'min_purchase'    => $item_new->first()->min_purchase,
                'description'     => $item_new->first()->description,
                'discount'        => $item_new->first()->discount,
                'price'           => $item_new->first()->price,
                'used'            => $item_new->first()->used,
                'home'            => $item_new->first()->home,
                'voucher'         => $item_new->first()->voucher,
                'status'          => $item_new->first()->status,
                'type'            => $item_new->first()->type,
            ], 200);           
        }
        Alert::success('Voucher', $item->name.' Successfully Create');        
        return redirect()->route('vouchers_adfood.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Coolze_voucher::with([
            'gallery','merchant'
        ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response([
                'status'          => 'OK',
                'name'            => $item->name,
                'merchants_id'    => $item->merchants_id,
                'name_merchant'   => $item->merchant->name,
                'foto'            => $item->gallery->sortBy('urutan'),
                'expired_at'      => $item->expired_at,
                'expired_at_time' => $item->expired_at_time,
                'coupon_code'     => $item->coupon_code,
                'min_purchase'    => $item->min_purchase,
                'description'     => $item->description,
                'discount'        => $item->discount,
                'price'           => $item->price,
                'used'            => $item->used,
                'home'            => $item->home,
                'voucher'         => $item->voucher,
                'status'          => $item->status,
                'type'            => $item->type,
                
                // 'status' => $sell_properties
            ], 200);
        }

        return view('pages.admin.vouchers-adfood.detail', [
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
        $item = Coolze_voucher::findOrFail($id);
        $item_merchants = User::where('merchants_id','!=',null)->get();

        return view('pages.admin.vouchers-adfood.edit', [
            'item' => $item,
            'item_merchants' => $item_merchants,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherRequest $request, $id)
    {
        
        $data = $request->all();
        
        if ($data['type'] == 'By One Get One') {
            $data['type'] = 11;
        }elseif($data['type'] == 'Free One Dish'){
            $data['type'] = 1;
        }

        $data['home'] = $request->home =='on'? 'on' : null ;
        $data['voucher'] = $request->voucher =='on' ? 'on' : null ;
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        // $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;         

        $this->validate($request, [
            // 'foto' => 'required',
            'foto.*' => 'mimes:jpeg,bmp,png',
        ]);

        $item = Coolze_voucher::with([
            'gallery'
        ])->findOrFail($id);

        try {

            
            //delete image
            // if ($request->file('foto') != null) {
            //     if(File::exists(('storage/'.$item->foto))){
            //         File::delete('storage/'.$item->foto);            
            //     }
            // }
            
            $item->update($data);

            $urutan = 10;
            if($request->hasfile('foto'))
            {
               foreach($request->file('foto') as $file)
               {
                //    $name = uniqid() .'.'.$file->extension();
                //    $file->move(public_path().'/storage/assets/multipleimage/', $name);  
                //    $dataUploadname[] = $name;
                $name = $file->store('assets/multipleimage', 'public');

                    $file= new Adfood_galleries_voucher();
                    $file->foto=$name;
                    $file->vouchers_id=$item->id;
                    $file->urutan=$urutan++;
                    $file->save();
                   
               }
            }
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
            $item_new = Coolze_voucher::with([
                'gallery','merchant'
            ])->findOrFail($id);

            return response([
                'success'         => True,
                'id'              => $item_new->id,
                'name'            => $item_new->name,
                'merchants_id'    => $item_new->merchants_id,
                'name_merchant'   => $item_new->merchant->name,
                'foto'            => $item_new->gallery->sortBy('urutan'),
                'expired_at'      => $item_new->expired_at,
                'expired_at_time' => $item_new->expired_at_time,
                'coupon_code'     => $item_new->coupon_code,
                'min_purchase'    => $item_new->min_purchase,
                'description'     => $item_new->description,
                'discount'        => $item_new->discount,
                'price'           => $item_new->price,
                'used'            => $item_new->used,
                'home'            => $item_new->home,
                'voucher'         => $item_new->voucher,
                'status'          => $item_new->status,
                'type'            => $item_new->type,
                
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('Voucher', $item->name.' Successfully Updated');           
        return redirect()->route('vouchers_adfood.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Coolze_voucher::with([
            'gallery','merchant'
        ])->findOrFail($id);
        //delete image
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }
        $item->update(['status' => 0]);

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'id'              => $item->id,
                'name'            => $item->name,
                'merchants_id'    => $item->merchants_id,
                'name_merchant'   => $item->merchant->name,
                'foto'            => $item->gallery->sortBy('urutan'),
                'expired_at'      => $item->expired_at,
                'expired_at_time' => $item->expired_at_time,
                'coupon_code'     => $item->coupon_code,
                'min_purchase'    => $item->min_purchase,
                'description'     => $item->description,
                'discount'        => $item->discount,
                'price'           => $item->price,
                'used'            => $item->used,
                'home'            => $item->home,
                'voucher'         => $item->voucher,
                'status'          => $item->status,
                'type'            => $item->type,
            ], 200);
        }
        Alert::success('Voucher ', $item->name.' Status Is Not Active');        
        return redirect()->route('vouchers_adfood.index');
    }

    public function destroy_permanen($id)
    {
        $item = Coolze_voucher::with([
            'gallery','merchant'
        ])->findOrFail($id);
        
        if ($item->gallery) {
            foreach ($item->gallery as $itemGallery) {
                File::delete('storage/'.$itemGallery->foto);   
                $itemGallery->delete();
            }
        }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'id'              => $item->id,
                'name'            => $item->name,
                'merchants_id'    => $item->merchants_id,
                'name_merchant'   => $item->merchant->name,
                'foto'            => $item->gallery->sortBy('urutan'),
                'expired_at'      => $item->expired_at,
                'expired_at_time' => $item->expired_at_time,
                'coupon_code'     => $item->coupon_code,
                'min_purchase'    => $item->min_purchase,
                'description'     => $item->description,
                'discount'        => $item->discount,
                'price'           => $item->price,
                'used'            => $item->used,
                'home'            => $item->home,
                'voucher'         => $item->voucher,
                'status'          => $item->status,
                'type'            => $item->type,
            ], 200);
        }
        Alert::success('Voucher ', $item->name.' Successfully Delete');        
        return redirect()->route('vouchers_adfood.index');
    }

    public function indexgallery()
    {
        $items = Adfood_galleries_voucher::with([
            'gallery'
        ])
        ->orderBy('created_at', 'DESC')
        ->get();

        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'data' => $items
                ], 200);
        }
        return view('pages.admin.foods-adfood.index', [
            'items' => $items,
            
        ]);
    }

    public function showgallery($id)
    {
        $item = Adfood_galleries_voucher::with([
            'gallery'
        ])
        ->orderBy('created_at', 'DESC')
        ->findOrFail($id);

        

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success'         => true,
                'message'         => 'List Id GalleryVoucher',
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
        $items = Adfood_galleries_voucher::with([
            'gallery'
        ])
        ->where('vouchers_id', $id)
        ->get();
        
        // $merchants = Users::with([
        //     'merchant'
        //     ])
        //     ->where('merchants_id',$item->merchants_id)
        //     ->where('status', 1)
        //     ->get();
            // dd($items->first()->foto);
        return view('pages.admin.vouchers-adfood.image', [
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
            $gallery = Adfood_galleries_voucher::find($id);

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
                    'vouchers_id'     => $gallery->vouchers_id
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

    public function destroy_voucher($id)
    {
        $item = Adfood_galleries_voucher::with([
            'gallery'
        ])
        ->findOrFail($id);
        
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success'         => true,
                'id'              => $item->id,
                'foto'            => $item->foto,
                'urutan'          => $item->urutan,
                'vouchers_id'     => $item->vouchers_id
                
            ], 200);
        }
        Alert::success('Image Voucher Successfully Delete');        
        // return redirect()->route('merchants.index');
        return back();
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Coolze_voucher::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-vouchers.index');
    }

    public function profile($id)
    {
        $voucher = Coolze_voucher::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'voucher', 'groomer'
            ])->where('vouchers_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $voucher
                    ], 200);
            }

        return view('pages.admin.profile-voucher', [
            'voucher' => $voucher,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'voucher', 'groomer'
        //     ])
        //     ->where('ongoings.vouchers_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'voucher', 'groomer'
            ])->where('vouchers_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-voucher', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'voucher', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'voucher', 'groomer'
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
            
        return view('pages.admin.invoice-voucher', [
            'items' => $items
        ]);
                
    }
}
