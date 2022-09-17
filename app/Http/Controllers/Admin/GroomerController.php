<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Groomer;
use App\Ongoing;
use App\Service;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\GroomerRequest;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class GroomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $items = Groomer::all();
        $items = Groomer::with([
            'service_groomer'
            ])->get();

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Groomer',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.services-groomer.index', [
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
        
        return view('pages.admin.services-groomer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroomerRequest $request)
    {
        $data = $request->all(); 
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;
        
        try {
            if ($request->file('foto') != null) {
                $item = Groomer::create([
                    'foto'              => $data['foto'],
                    'name'              => $request->name,
                    'kategori'          => $request->kategori,
                    'lokasi'            => $request->lokasi,
                    'lat'               => $request->lat,
                    'long'              => $request->long,
                    'transaksi'         => $request->transaksi,
                    'status'            => $request->status,
                    'harga'             => $request->harga,
                    'pengalaman'        => $request->pengalaman,
                    'jangka'            => $request->jangka,
                    'tentang'           => $request->tentang,
                ]);
            }else{
                $item = Groomer::create([
                    
                    'name'              => $request->name,
                    'kategori'          => $request->kategori,
                    'lokasi'            => $request->lokasi,
                    'lat'               => $request->lat,
                    'long'              => $request->long,
                    'transaksi'         => $request->transaksi,
                    'status'            => $request->status,
                    'harga'             => $request->harga,
                    'pengalaman'        => $request->pengalaman,
                    'jangka'            => $request->jangka,
                    'tentang'           => $request->tentang,
                ]);
            }
            
            
            foreach ($request->layanan as $key => $value) {
                    
                Service::create([
                    'partners_id' => $item->id,
                    'partners'=>'G',
                    'title' => $value
                ]);
            }
            $item_new = Groomer::with([
                'service_groomer'
                ])->findOrFail($item->id);
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item_new
                ], 401);
            }
            // return back()->with('error', 'Error Create : '.getMessage() );
            return back()->with('error', 'Error Create');
        }    

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Groomer',
                'data' => $item_new
            ], 200);           
        }

        Alert::success('Groomers Ditambahkan', $item_new->name.' berhasil ditambahkan');        
        return redirect()->route('services-groomer.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $item = Groomer::with([
            'service_groomer'
            ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Groomer '.$item->name,
                'data' => $item,
                ], 200);
        }

        return view('pages.admin.services-groomer.detail', [
            'item' => $item,
            
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
        $layanan = Service::where('partners_id', $id)->where('partners','G')
        ->get();
        $item = Groomer::with([
            'service_groomer'
            ])->findOrFail($id);
        // $services = Service::all();
        return view('pages.admin.services-groomer.edit', [
            'item' => $item,
            'layanan' => $layanan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroomerRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;
        $item = Groomer::findOrFail($id);

        
        try {
            //delete image
            if ($request->file('foto') != null) {
                if(File::exists(('storage/'.$item->foto))){
                    File::delete('storage/'.$item->foto);            
                }
            }

            if ($request->file('foto') != null) {
                $itemupdate = $item->update([
                    'foto'              => $data['foto'],
                    'name'              => $request->name,
                    'kategori'          => $request->kategori,
                    'lokasi'            => $request->lokasi,
                    'lat'               => $request->lat,
                    'long'              => $request->long,
                    'transaksi'         => $request->transaksi,
                    'status'            => $request->status,
                    'harga'             => $request->harga,
                    'pengalaman'        => $request->pengalaman,
                    'jangka'            => $request->jangka,
                    'tentang'           => $request->tentang,
                ]);
            } else {
                $itemupdate = $item->update([
                    'name'              => $request->name,
                    'kategori'          => $request->kategori,
                    'lokasi'            => $request->lokasi,
                    'lat'               => $request->lat,
                    'long'              => $request->long,
                    'transaksi'         => $request->transaksi,
                    'status'            => $request->status,
                    'harga'             => $request->harga,
                    'pengalaman'        => $request->pengalaman,
                    'jangka'            => $request->jangka,
                    'tentang'           => $request->tentang,
                ]);
            }
        

            Service::where('partners_id',$id)->where('partners','G')->delete();
            
            foreach ($request->layanan as $key => $value) {
                
                Service::create([
                    'partners_id' => $id,
                    'partners'=>'G',
                    'title' => $value
                ]);
            }


        

        $item_new = Groomer::with([
            'service_groomer'
            ])->findOrFail($id);
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

        Alert::success('Groomers Diupdate', $item->name.' berhasil diupdate');   
        return redirect()->route('services-groomer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Groomer::with([
            'service_groomer'
            ])->findOrFail($id);
        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }    
        $item->delete();
        
        Service::where('partners_id',$id)
            ->where('partners','G')
            ->delete();
        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->name,
                'data' => $item
            ], 200);
        }
        
        Alert::success('Groomers Dihapus', $item->name.' berhasil dihapus');
        
        return redirect()->route('services-groomer.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Groomer::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-groomer.index');
    }

    public function profile($id)
    {
        $groomer = Groomer::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'doctor', 'groomer'
            ])->where('groomers_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $groomer
                    ], 200);
            }

        return view('pages.admin.profile-groomer', [
            'groomer' => $groomer,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        $items = Ongoing::with([
            'customer', 'doctor', 'groomer'
            ])->where('groomers_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-groomer', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        
        $items = Ongoing::with([
            'customer', 'doctor', 'groomer'
            ])->where('id', $id)
            // ->orderBy('created_at', 'DESC')
            ->get();
            

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Invoice'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.invoice-groomer', [
            'items' => $items
        ]);
                
    }

    public function ulasangroomer($id)
    {
        
        try {
            $ongoings = Ongoing::with([
                'customer', 'doctor', 'groomer'
                ])
                ->where('isreviewed', 1)
                ->where('groomer_id', $id)
                    // ->where('acc', '!=', null)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    
            foreach ($ongoings as $ongoing) {
                $ongoing_array[] = $ongoing;
            } 
            
        }catch (QueryException $e) {
                if(\Request::segment(1) == 'api') {
                    return response([
                        'status' => 'error',
                        'message' => 'Gagal mengambil',
                        'data' => $ongoings
                        // 'status' => $sell_properties
                    ], 401);
                }
                // return back()->with('error', 'Error Update : '.getMessage() );
                // return back()->with('error', 'Error Update');
            }  

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Yang Ulasan/isreviewed true',
                    'data' => $ongoing_array
                    ], 200);
            }

        // return view('pages.admin.profile-doctor', [
        //     'doctor' => $doctor,
        //     'ongoings' => $ongoings
        // ]);        
    }
}
