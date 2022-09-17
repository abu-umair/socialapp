<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Adfood_stripe;
use App\Ongoing;
use App\User;
use App\Adfood_galleries_voucher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StripeRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\True_;

class Stripe_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Adfood_stripe::with([
            'merchant','merchant_lengkap','gallerymerchant',
            ])->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'data' => $items
                ], 200);
        }

        return view('pages.admin.stripes-adfood.index', [
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
        
        return view('pages.admin.stripes-adfood.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StripeRequest $request)
    {
        $data = $request->all();
        try {
            $item = Adfood_stripe::create($data);
            
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
            $item_new = Adfood_stripe::with([
                'merchant','merchant_lengkap','gallerymerchant',
                ])->where('id', $item->id)->get();
            return response([
                'succes'          => True,
                'item'          => $item_new,
                // 'id'              => $item_new->first()->id,
                // 'card_information'=> $item_new->first()->card_information,
                // 'date'            => $item_new->first()->date,
                // 'cvc'             => $item_new->first()->cvc,
                // 'country_region'  => $item_new->first()->country_region,
                // 'zip'             => $item_new->first()->zip,
            ], 200);           
        }
        Alert::success('Stripe', $item->card_information.' Successfully Create');        
        return redirect()->route('stripes-adfood.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Adfood_stripe::with([
            'merchant','merchant_lengkap','gallerymerchant',
            ])
            ->has('merchant_lengkap')
            ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'item'            => $item,
                // 'id'              => $item->id,
                // 'card_information'=> $item->card_information,
                // 'date'            => $item->date,
                // 'cvc'             => $item->cvc,
                // 'country_region'  => $item->country_region,
                // 'zip'             => $item->zip,
            ], 200);
        }
        return view('pages.admin.stripes-adfood.detail', [
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
        $item = Adfood_stripe::findOrFail($id);

        return view('pages.admin.stripes-adfood.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StripeRequest $request, $id)
    {
        
        $data = $request->all();
        $item = Adfood_stripe::findOrFail($id);
        try {
            
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
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            $item_new = Adfood_stripe::with([
                'merchant','merchant_lengkap','gallerymerchant',
                ])->where('id', $item->id)->get();

            return response([
                'succes'          => True,
                'item'            => $item_new,
                // 'id'              => $item_new->id,
                // 'card_information'=> $item_new->card_information,
                // 'date'            => $item_new->date,
                // 'cvc'             => $item_new->cvc,
                // 'country_region'  => $item_new->country_region,
                // 'zip'             => $item_new->zip,
            ], 200);
        }
        Alert::success('Stripe', $item->card_information.' Successfully Updated');           
        return redirect()->route('stripes-adfood.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Adfood_stripe::findOrFail($id);
        //delete image
        // if(File::exists(('storage/'.$item->foto))){
        //     File::delete('storage/'.$item->foto);            
        // }
        $item->update(['status' => 0]);

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'item'            => $item,
            ], 200);
        }
        Alert::success('Stripe ', $item->card_information.' Status Is Not Active');        
        return redirect()->route('stripes-adfood.index');
    }

    public function destroy_permanen($id)
    {
        $item = Adfood_stripe::with([
            'merchant','merchant_lengkap','gallerymerchant',
            ])->findOrFail($id);
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'succes'          => True,
                'item'            => $item,
            ], 200);
        }
        Alert::success('Stripe ', $item->card_information.' Successfully Delete');        
        return redirect()->route('stripes-adfood.index');
    }

    public function show_by_merchant($id)
    {
        $item = Adfood_stripe::with([
            'merchant','merchant_lengkap','gallerymerchant',
            ])
            ->has('merchant_lengkap')
            ->where('merchants_id',$id)
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
        return view('pages.admin.stripes-adfood.image', [
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
        Alert::success('Image Stripe Successfully Delete');        
        // return redirect()->route('merchants.index');
        return back();
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Adfood_stripe::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-vouchers.index');
    }

    public function profile($id)
    {
        $voucher = Adfood_stripe::findOrFail($id);
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
