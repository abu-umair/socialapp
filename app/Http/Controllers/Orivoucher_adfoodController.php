<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Adfood_ori_vouchers;
use App\Ongoing;
use App\User;
use App\Adfood_galleries_voucher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\OrivoucherRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\True_;

class Orivoucher_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Adfood_ori_vouchers::with([
            'merchant','merchant_lengkap'
        ])
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

        return view('pages.admin.orivouchers-adfood.index', [
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
        return view('pages.admin.orivouchers-adfood.create', [
            'items' => $items
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrivoucherRequest $request)
    {
        $data = $request->all();
        
        $data['home'] = $request->home =='on'? 'on' : null ;
        $data['voucher'] = $request->voucher =='on' ? 'on' : null ;
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;         
        try {
            $item = Adfood_ori_vouchers::create($data);
            
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
            $item_new = Adfood_ori_vouchers::where('id', $item->id)->get();
            return response([
                'succes'          => True,
                'id'              => $item_new->first()->id,
                'name'            => $item_new->first()->name,
                'foto'            => $item_new->first()->foto,
                'merchants_id'    => $item_new->first()->merchants_id,
                'name_merchant'   => $item_new->first()->merchant->name,
                'coupon_code'     => $item_new->first()->coupon_code,
                'start_date'      => $item_new->first()->start_date,
                'end_date'        => $item_new->first()->end_date,
                'min_purchase'    => $item_new->first()->min_purchase,
                'description'     => $item_new->first()->description,
                'discount'        => $item_new->first()->discount,
                'home'            => $item_new->first()->home,
                'voucher'         => $item_new->first()->voucher,
                'status'          => $item_new->first()->status,
            ], 200);           
        }
        Alert::success('Voucher', $item->name.' Successfully Create');        
        return redirect()->route('orivouchers-adfood.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Adfood_ori_vouchers::with([
            'merchant'
        ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'id'              => $item->id,
                'name'            => $item->name,
                'foto'            => $item->foto,
                'merchants_id'    => $item->merchants_id,
                'name_merchant'   => $item->merchant->name,
                'coupon_code'     => $item->coupon_code,
                'start_date'      => $item->start_date,
                'end_date'        => $item->end_date,
                'min_purchase'    => $item->min_purchase,
                'description'     => $item->description,
                'discount'        => $item->discount,
                'home'            => $item->home,
                'voucher'         => $item->voucher,
                'status'          => $item->status,
                
                // 'status' => $sell_properties
            ], 200);
        }

        return view('pages.admin.orivouchers-adfood.detail', [
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
        $item = Adfood_ori_vouchers::findOrFail($id);
        $item_merchants = User::where('merchants_id','!=',null)->get();

        return view('pages.admin.orivouchers-adfood.edit', [
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
    public function update(OrivoucherRequest $request, $id)
    {
        
        $data = $request->all();
        
        $data['home'] = $request->home =='on'? 'on' : null ;
        $data['voucher'] = $request->voucher =='on' ? 'on' : null ;
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;         

        

        $item = Adfood_ori_vouchers::findOrFail($id);

        try {

            
            //delete image
            if ($request->file('foto') != null) {
                if(File::exists(('storage/'.$item->foto))){
                    File::delete('storage/'.$item->foto);            
                }
            }
            
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
            $item_new = Adfood_ori_vouchers::with([
                'merchant'
            ])->findOrFail($id);

            return response([
                'succes'          => True,
                'id'              => $item_new->id,
                'name'            => $item_new->name,
                'foto'            => $item_new->foto,
                'merchants_id'    => $item_new->merchants_id,
                'name_merchant'   => $item_new->merchant->name,
                'coupon_code'     => $item_new->coupon_code,
                'start_date'      => $item_new->start_date,
                'end_date'        => $item_new->end_date,
                'min_purchase'    => $item_new->min_purchase,
                'description'     => $item_new->description,
                'discount'        => $item_new->discount,
                'home'            => $item_new->home,
                'voucher'         => $item_new->voucher,
                'status'          => $item_new->status,
                
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('Voucher', $item->name.' Successfully Updated');           
        return redirect()->route('orivouchers-adfood.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Adfood_ori_vouchers::with([
            'merchant'
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
                'foto'            => $item->foto,
                'merchants_id'    => $item->merchants_id,
                'name_merchant'   => $item->merchant->name,
                'coupon_code'     => $item->coupon_code,
                'start_date'      => $item->start_date,
                'end_date'        => $item->end_date,
                'min_purchase'    => $item->min_purchase,
                'description'     => $item->description,
                'discount'        => $item->discount,
                'home'            => $item->home,
                'voucher'         => $item->voucher,
                'status'          => $item->status,
            ], 200);
        }
        Alert::success('Voucher ', $item->name.' Status Is Not Active');        
        return redirect()->route('orivouchers-adfood.index');
    }

    public function destroy_permanen($id)
    {
        $item = Adfood_ori_vouchers::with([
            'merchant'
        ])->findOrFail($id);
        
        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }

        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'id'              => $item->id,
                'name'            => $item->name,
                'foto'            => $item->foto,
                'merchants_id'    => $item->merchants_id,
                'name_merchant'   => $item->merchant->name,
                'coupon_code'     => $item->coupon_code,
                'start_date'      => $item->start_date,
                'end_date'        => $item->end_date,
                'min_purchase'    => $item->min_purchase,
                'description'     => $item->description,
                'discount'        => $item->discount,
                'home'            => $item->home,
                'voucher'         => $item->voucher,
                'status'          => $item->status,
            ], 200);
        }
        Alert::success('Voucher ', $item->name.' Successfully Delete');        
        return redirect()->route('orivouchers-adfood.index');
    }

    public function showbymerchant($id)
    {
        $item = Adfood_ori_vouchers::with([
            'merchant'
        ])
        ->where('merchants_id',$id)
        ->has('merchant')
        ->get();

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'item'            => $item,
                // 'id'              => $item->id,
                // 'name'            => $item->name,
                // 'foto'            => $item->foto,
                // 'merchants_id'    => $item->merchants_id,
                // 'name_merchant'   => $item->merchant->name,
                // 'coupon_code'     => $item->coupon_code,
                // 'start_date'      => $item->start_date,
                // 'end_date'        => $item->end_date,
                // 'min_purchase'    => $item->min_purchase,
                // 'description'     => $item->description,
                // 'discount'        => $item->discount,
                // 'home'            => $item->home,
                // 'voucher'         => $item->voucher,
                // 'status'          => $item->status,
                
                // 'status' => $sell_properties
            ], 200);
        }

        return view('pages.admin.orivouchers-adfood.detail', [
            'item' => $item
        ]);
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
        return view('pages.admin.orivouchers-adfood.image', [
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
        $resore_Soft_Delete = Adfood_ori_vouchers::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-vouchers.index');
    }

    public function profile($id)
    {
        $voucher = Adfood_ori_vouchers::findOrFail($id);
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
