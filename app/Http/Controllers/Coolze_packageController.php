<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Coolze_package;
use App\Coolze_subpackage;
use App\Ongoing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PackageRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Coolze_packageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Coolze_package::with([
            'subpackage'
        ])
            ->where('status', 1)
            ->get();
        // $user= Auth::user()->roles;
        
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Packages',
                'data' => $items
                ], 200);
        }
        
        // $packages_array = json_encode($packages_array);
        return view('pages.admin.packages-coolze.index', [
            'items'     => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.packages-coolze.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $data = $request->all();
        
        try {
            $item_package = Coolze_package::create([
                'title' => $request->title,
            ]);
            
            $item_subpackage = Coolze_subpackage::create([
                'packages_id'        => $item_package->id,
                'deskripsi_title'    => $request->deskripsi_title,
                'price_dasar'        => $request->price_dasar,
                'price_diskon'       => $request->price_diskon,
            ]);
            
            $item_new = Coolze_package::with([
                'subpackage'
            ])->where('id',$item_package->id)
                ->get();
        } catch (QueryException $e) {
            
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item_new
                ], 401);
            }
            return back()->with('error', 'Error Create');
        }    
        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Package',
                'data' => $item_new
            ], 200);           
        }
        
        Alert::success('Package Ditambahkan', $item_new[0]->title.' berhasil ditambahkan');        
        return redirect()->route('packages.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Coolze_package::with([
            'subpackage'
        ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Package '.$item->title,
                'data' => $item
                ], 200);
        }

        return view('pages.admin.content.detail', [
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
        $item = Coolze_package::with([
            'subpackage'
        ])->findOrFail($id);

        return view('pages.admin.packages-coolze.edit', [
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
    public function update(PackageRequest $request, $id)
    {
        
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        
        $item = Coolze_package::findOrFail($id);
        $item_sub = Coolze_subpackage::where('packages_id',$item->id)->get();
        
        try {
            $item_package = $item->update([
                'title' => $request->title,
            ]);
            $item_subpackage = $item_sub[0]->update([
                'packages_id' => $item->id,
                'deskripsi_title'    => $request->deskripsi_title,
                'price_dasar'        => $request->price_dasar,
                'price_diskon'       => $request->price_diskon,
            ]);
            $item_new = Coolze_package::with([
                'subpackage'
            ])->findOrFail($id);  
            // $item->update($data);
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item_new
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
                'data' => $item_new
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('Package Diupdate', $item_new->title.' berhasil diupdate');           
        return redirect()->route('packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Coolze_package::with([
            'subpackage'
        ])->findOrFail($id);
        // $item_sub = Coolze_subpackage::where('packages_id',$item->id)->get();
        
        $item->update(['status' => 0]);
        // $item_sub[0]->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        Alert::success('Package Dihapus', $item->title.' berhasil dihapus');        
        return redirect()->route('packages.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Coolze_package::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-content.index');
    }

    public function profile($id)
    {
        $content = Coolze_package::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'content', 'groomer'
            ])->where('contents_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $content
                    ], 200);
            }

        return view('pages.admin.profile-content', [
            'content' => $content,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'content', 'groomer'
        //     ])
        //     ->where('ongoings.contents_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'content', 'groomer'
            ])->where('contents_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-content', [
            'items' => $items,
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'content', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'content', 'groomer'
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
            
        return view('pages.admin.invoice-content', [
            'items' => $items
        ]);
                
    }
}
