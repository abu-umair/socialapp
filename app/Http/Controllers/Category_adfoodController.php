<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Adfood_category;
use App\Ongoing;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Category_adfoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Adfood_category::orderBy('created_at', 'DESC')->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'data' => $items
                ], 200);
        }

        return view('pages.admin.category-adfood.index', [
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
        return view('pages.admin.category-adfood.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['foto'] = $request->file('foto') != null ? $request->file('foto')->store('assets/gallery', 'public') : null;         
        try {
            $item = Adfood_category::create($data);
            // dd($item);
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
            return response([
                'success' => True,
                'data' => $item
            ], 200);           
        }
        Alert::success('Adfood_category ', $item->title.' Successfully Create');        
        return redirect()->route('category-adfood.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Adfood_category::orderBy('created_at', 'DESC')->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'data' => $item
                ], 200);
        }

        return view('pages.admin.category-adfood.detail', [
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
        $item = Adfood_category::findOrFail($id);

        return view('pages.admin.category-adfood.edit', [
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
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        // $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : $data['foto'] = null;
        
        // $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;

        $item = Adfood_category::findOrFail($id);
        try {
            //delete image
            if ($request->file('foto') != null) {
                $data['foto'] = $request->file('foto')->store('assets/gallery', 'public');
                
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
                    'data' => $item
                    // 'status' => $sell_properties
                ], 401);
            }
            // return back()->with('error', 'Error Update : '.getMessage() );
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            return response([
                'success' => True,
                'data' => $item
                // 'status' => $sell_properties
            ], 200);
        }
        Alert::success('Category ', $item->title.' Successfully Updated');           
        return redirect()->route('category-adfood.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Adfood_category::findOrFail($id);
        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success' => True,
                'data' => $item
            ], 200);
        }
        Alert::success('Category ', $item->category.' Successfully Delete');        
        return redirect()->route('category-adfood.index');
    }

    public function destroy_permanen($id)
    {
        $item = Adfood_category::findOrFail($id);
        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }
        $item->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'success' => True,
                'data' => $item
            ], 200);
        }
        Alert::success('Category ', $item->category.' Successfully Delete');        
        return redirect()->route('category-adfood.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Adfood_category::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-category-adfood.index');
    }


    
    

    public function profile($id)
    {
        $categories = Adfood_category::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'category-adfood', 'groomer'
            ])->where('categorys_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoings, $categories
                    ], 200);
            }

        return view('pages.admin.profile-category-adfood', [
            'category-adfood' => $categories,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'category-adfood', 'groomer'
        //     ])
        //     ->where('ongoings.categorys_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'category-adfood', 'groomer'
            ])->where('categorys_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-category-adfood', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'category-adfood', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'category-adfood', 'groomer'
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
            
        return view('pages.admin.invoice-category-adfood', [
            'items' => $items
        ]);
                
    }
}
