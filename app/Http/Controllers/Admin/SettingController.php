<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use App\Ongoing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\SettingRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $items = Setting::all();
        // // $user= Auth::user()->roles;

        // if(\Request::segment(1) == 'api') {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'List Semua Setting',
        //         'data' => $items
        //         ], 200);
        // }

        return view('pages.admin.settings-adfood.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.settings-adfood.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        $data = $request->all();
        $data['url'] = $request->file('url') != null ? $request->file('url')->store('assets/gallery', 'public') : null;         
        try {
            $item = Setting::create($data);
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
                'message' => 'Berhasil Disimpan Setting',
                'data' => $item
            ], 200);           
        }
        Alert::success('Setting Ditambahkan', $item->title.' berhasil ditambahkan');        
        return redirect()->route('setting.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Setting::findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Setting '.$item->title,
                'data' => $item
                ], 200);
        }

        return view('pages.admin.setting.detail', [
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
        $item = Setting::findOrFail($id);

        return view('pages.admin.settings-adfood.edit', [
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
    public function update(SettingRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        // $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : $data['foto'] = null;

        $request->file('url') != null ? $data['url'] = $request->file('url')->store('assets/gallery', 'public') : null;

        $item = Setting::findOrFail($id);
        try {
            //delete image
            if ($request->file('url') != null) {
                if(File::exists(('storage/'.$item->url))){
                    File::delete('storage/'.$item->url);            
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
        Alert::success('Setting Diupdate', $item->title.' berhasil diupdate');           
        return redirect()->route('setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Setting::findOrFail($id);
        //delete image
        if(File::exists(('storage/'.$item->url))){
            File::delete('storage/'.$item->url);            
        }
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        Alert::success('Setting Dihapus', $item->title.' berhasil dihapus');        
        return redirect()->route('setting.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Setting::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-setting.index');
    }


    
    

    public function profile($id)
    {
        $setting = Setting::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'setting', 'groomer'
            ])->where('settings_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $setting
                    ], 200);
            }

        return view('pages.admin.profile-setting', [
            'setting' => $setting,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'setting', 'groomer'
        //     ])
        //     ->where('ongoings.settings_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'setting', 'groomer'
            ])->where('settings_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-setting', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'setting', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'setting', 'groomer'
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
            
        return view('pages.admin.invoice-setting', [
            'items' => $items
        ]);
                
    }
}
