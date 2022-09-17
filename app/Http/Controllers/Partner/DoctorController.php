<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Doctor;
use App\Ongoing;
use App\Service;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\DoctorRequest;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $items = Doctor::with([
            'service_doctor'   
            ])->get();
        // $user= Auth::user()->roles;
        // ->join('services','services.id', '=','metode_layanan')
       
        
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Doctor',
                'data' => $items,
               
                ], 200);
        }

        return view('pages.admin.services-doctor.index', [
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
        
        return view('pages.admin.services-doctor.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
        // dd($request->layanan);
        $data = $request->all();
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null; 
                
        try {
            if ($request->file('foto') != null) {
                $item = Doctor::create([
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
                $item = Doctor::create([
                    
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
                        'partners'=>'D',
                        'title' => $value
                    ]);
                }
                $item_new = Doctor::with([
                    'service_doctor'
                    ])->findOrFail($item->id);
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
                'message' => 'Berhasil Disimpan Doctor',
                'data' => $item_new,
                // 'data layanan' => $item_layanan
            ], 200);           
        }
        Alert::success('Doctor Ditambahkan', $item_new->name.' berhasil ditambahkan');        
        return redirect()->route('services-doctor.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $item = Doctor::with([
            'service_doctor',
            ])->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Doctor '.$item->name,
                'data' => $item,
                // 'data layanan' => $layanan
                ], 200);
        }

        return view('pages.admin.services-doctor.detail', [
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
        $layanan = Service::where('partners_id', $id)->where('partners','D')
                ->get();
                // dd($layanan);
        $item = Doctor::with([
            'service_doctor'
            ])->findOrFail($id);

        return view('pages.admin.services-doctor.edit', [
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
    public function update(DoctorRequest $request, $id)
    {
        $data = $request->all();
        //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
        

        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;

        $item = Doctor::findOrFail($id);

        
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
            
            
            Service::where('partners_id',$id)->where('partners','D')->delete();
            
            foreach ($request->layanan as $key => $value) {
                
                Service::create([
                    'partners_id' => $id,
                    'partners'=>'D',
                    'title' => $value
                ]);
            }

        $item_new = Doctor::with([
            'service_doctor'
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
        Alert::success('Doctor Diupdate', $item->name.' berhasil diupdate');           
        return redirect()->route('services-doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Doctor::with([
            'service_doctor'
            ])->findOrFail($id);
        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }

        $item->delete();        
        Service::where('partners_id',$id)
            ->where('partners','D')
            ->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->name,
                'data' => $item
            ], 200);
        }
        Alert::success('Doctor Dihapus', $item->name.' berhasil dihapus');        
        return redirect()->route('services-doctor.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Doctor::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-doctor.index');
    }

    public function profile($id)
    {
        $doctor = Doctor::findOrFail($id);
        $ongoings = Ongoing::with([
            'customer', 'doctor', 'groomer'
            ])->where('doctors_id', $id)
                // ->where('acc', '!=', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Ongoing',
                    'data' => $ongoing, $doctor
                    ], 200);
            }

        return view('pages.admin.profile-doctor', [
            'doctor' => $doctor,
            'ongoings' => $ongoings
        ]);        
    }

    public function transaksi($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'doctor', 'groomer'
        //     ])
        //     ->where('ongoings.doctors_id', $id)
            
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $items = Ongoing::with([
            'customer', 'doctor', 'groomer','user'
            ])->where('doctors_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Transaction'.$id,
                    'data' => $items
                    ], 200);
            }
            
        return view('pages.admin.transactions-doctor', [
            'items' => $items
        ]);        
    }

    public function invoice($id)
    {
        // $items = Ongoing::select('ongoings.*')
        // ->join('customers','customers.id', '=','ongoings.customers_id')
        // ->join('users','users.customers_id', '=','customers.id')
        // ->with([
        //     'customer', 'doctor', 'groomer'
        //     ])
        //     ->where('ongoings.id', $id)
            
        //     // ->orderBy('created_at', 'DESC')
        //     ->get();
        $items = Ongoing::with([
            'customer', 'doctor', 'groomer'
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
            
        return view('pages.admin.invoice-doctor', [
            'items' => $items
        ]);
                
    }

    public function ulasandoctor($id)
    {
        
        try {
            $ongoings = Ongoing::with([
                'customer', 'doctor', 'groomer'
                ])
                ->where('isreviewed', 1)
                ->where('doctors_id', $id)
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
