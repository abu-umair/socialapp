<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use Illuminate\Http\Request;
use App\Service;
use App\Customer;
use App\Doctor;
use App\Groomer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Service::all();
        // $items = Service::all();
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Layanan',
                'data' => $items
                ], 200);
        }

        
        return view('pages.admin.services.index', [
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
        return view('pages.admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->all();
        
        try {
            $item = Service::create($data);
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
                'message' => 'Berhasil Disimpan Layanan',
                'data' => $item
            ], 200);           
        }

        Alert::success('Service Ditambahkan', $item->title.' berhasil ditambahkan');        
        return redirect()->route('services.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Service::findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Layanan '.$item->title,
                'data' => $item
                ], 200);
        }

        return view('pages.admin.services.detail', [
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
        $item = Service::findOrFail($id);

        return view('pages.admin.services.edit', [
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
    public function update(ServiceRequest $request, $id)
    {
        $data = $request->all();
        $item = Service::findOrFail($id);
        try {
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
        Alert::success('Layanan Diupdate', $item->title.' berhasil diupdate');           
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Service::findOrFail($id);
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->title,
                'data' => $item
            ], 200);
        }
        Alert::success('Layanan Dihapus', $item->title.' berhasil dihapus');        
        return redirect()->route('services.index');
    }
}
