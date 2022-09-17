<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Coolze_driver;
use App\Ongoing;
use App\Users;
use App\User;
use Seshac\Otp\Otp;
use App\Http\Requests\Admin\DriverRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use App\Coolze_order;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            
            return $next($request);
        });
    }
    
    public function index()
    {
            
            $items = Coolze_driver::with([
                'partner','partner_lengkap','driver_lengkap','order'
            ])
            ->where('partners_id', $this->user->id)
            //dimana table user, statusnya 1 (yang diselect awal Coolze_driver) 
            ->whereHas('driver_lengkap', function($q) { 
                    $q->where('status', 1);
                })
            
                // ->whereRelation('status', 1) (laravel 8 pakai whereRelation)
            ->get();
            // https://medium.com/backenders-club/using-pluck-and-wherein-in-laravel-2dce9fb5033b
            

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Driver',
                    'data' => $items
                    ], 200);
            }
            return view('pages.admin.drivers-coolze.index', [
                'items' => $items
            ]);
        
    }

    public function PartnerWithId()
    {
        $items = Coolze_driver::with([
            'partner','partner_lengkap','driver_lengkap','order'
        ]) //dimana table user, statusnya 1 (yang diselect awal Coolze_driver) 
        ->whereHas('driver_lengkap', function($q) { 
                $q->where('status', 1);
            })
            // ->whereRelation('status', 1) (laravel 8 pakai whereRelation)
        ->get();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Driver',
                'data' => $items
                ], 200);
        }
        return view('pages.admin.drivers-coolze.index', [
            'items' => $items
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $items_partners = Users::where('partners_id','!=', null)
    //         ->where('status', 1)
    //         ->get();
    //     return view('pages.admin.drivers-coolze.create',[
    //         'items_partners'    =>  $items_partners,
    //     ]);
    // }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(DriverRequest $request)
    // {
    //     $request->validate([
    //         'email'             => 'unique:users',
    //         'phone'             => 'unique:users',
    //         // 'no_anggota'        => 'unique:coolze_drivers',
    //     ]);
        
    //     $data = $request->all();
        
    //     $data['foto'] = $request->file('foto') != null ? $request->file('foto')->store('assets/gallery', 'public') : null;         
    //     $identifier = Str::random(12);
    //     $no_anggota =  Otp::setValidity(3)  // otp validity time in mins
    //                         ->setLength(6)  // Lenght of the generated otp
    //                         ->setMaximumOtpsAllowed(100) // Number of times allowed to regenerate otps
    //                         ->setOnlyDigits(true)  // generated otp contains mixed characters ex:ad2312
    //                         ->setUseSameToken(false) // if you re-generate OTP, you will get same token
    //                         ->generate($identifier);
    //     try {

    //         $item_user = Users::create([
    //             'foto'         => $data['foto'],
    //             'name'         => $request->name,
    //             'email'        => $request->email,
    //             'password'     => $request->password,
    //             'phone'        => $request->phone,
    //             'isVerified'   => $request->isVerified,
    //             'roles'        => $request->roles,
    //             'customers_id' => null,    
    //         ]);


    //         $item = Coolze_driver::create([
    //                 'id'           => $item_user->id,
    //                 'partners_id'  => $request->partners_id,
    //                 'name'         => $request->name,
    //                 'no_anggota'   => $no_anggota->token,
    //                 'tarif'        => $request->tarif,
    //                 'long'         => $request->long,
    //                 'lat'          => $request->lat,
    //                 'alamat'       => $request->alamat,
    //         ]);
    //         $item_user->update([
    //             'drivers_id'         => $item->id,
    //         ]);
            
            
    //         // dd($item);
    //     } catch (QueryException $e) {
    //         if(\Request::segment(1) == 'api') {
    //             return response([
    //                 'status' => 'error',
    //                 'message' => 'Gagal Disimpan',
    //                 'data' => $item
    //             ], 401);
    //         }
    //         return back()->with('error', 'Error Create');
    //     }    
    //     if(\Request::segment(1) == 'api') {
    //         $item_new = Coolze_driver::with([
    //             'partner','partner_lengkap','driver_lengkap','order'
    //         ])->where('id', $item->id)->get();
    //         return response([
    //             'status' => 'OK',
    //             'message' => 'Berhasil Disimpan Driver',
    //             'data' => $item_new
    //         ], 200);           
    //     }
    //     Alert::success('Driver Ditambahkan', $item_user->name.' berhasil ditambahkan');        
    //     return redirect()->route('drivers.index');
        
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $item = Coolze_driver::with([
    //         'partner','partner_lengkap','driver_lengkap','order'
    //     ])
    //     ->findOrFail($id);
       
    //     if(\Request::segment(1) == 'api') {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Get Driver '.$item->name,
    //             'data' => $item
    //             ], 200);
    //     }

    //     return view('pages.admin.drivers.detail', [
    //         'item' => $item
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $items_partners = Users::where('partners_id','!=', null)
    //         ->where('status', 1)
    //         ->get();
    //     $item = Coolze_driver::with([
    //         'partner','partner_lengkap','driver_lengkap','order'
    //     ])
    //     ->findOrFail($id);

    //     return view('pages.admin.drivers-coolze.edit', [
    //         'item'              => $item,
    //         'items_partners'    => $items_partners,
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(DriverRequest $request, $id)
    // {
        
    //     $data = $request->all();
    //     //$data['slug'] = Str::slug($request->title); //menambahkan slug, sebagai ID tapi lebih cantiknya
    //     $data['foto'] = $request->file('foto') != null ? $request->file('foto')->store('assets/gallery', 'public') : null;         

    //     $item = Coolze_driver::findOrFail($id);
    //     $item_driver = Users::where('drivers_id', $id)->first();
        
    //     try {
    //         //delete image
    //         if ($request->file('foto') != null) { //jika foto ada
    //             if(File::exists(('storage/'.$item_driver->foto))){
    //                 File::delete('storage/'.$item_driver->foto);    
    //             } 

    //             if ($request->password) {
    //                 $item_driver->update([
    //                     'foto'         => $data['foto'],
    //                     'name'         => $request->name,
    //                     'email'        => $request->email,
    //                     'password'     => $request->password,
    //                     'phone'        => $request->phone,
    //                     'isVerified'   => $request->isVerified,
    //                     'roles'        => $request->roles,
    //                     'customers_id' => null,
    //                     'drivers_id'   => $id,
    //                  ]);
    //             } else {
    //                 $item_driver->update([
    //                     'foto'         => $data['foto'],
    //                     'name'         => $request->name,
    //                     'email'        => $request->email,
    //                     'phone'        => $request->phone,
    //                     'isVerified'   => $request->isVerified,
    //                     'roles'        => $request->roles,
    //                     'customers_id' => null,
    //                     'drivers_id'   => $id,
    //                  ]);
    //             }
                
                

    //         } else{ //JIKA FOTO TIDAK ADA
                
    //             if ($request->password) {
    //                 $item_driver->update([
    //                     'name'         => $request->name,
    //                     'email'        => $request->email,
    //                     'password'     => $request->password,
    //                     'phone'        => $request->phone,
    //                     'isVerified'   => $request->isVerified,
    //                     'roles'        => $request->roles,
    //                     'customers_id' => null,
    //                     'drivers_id'   => $id,
    //                  ]);
    //             } else {
    //                 $item_driver->update([
    //                     'name'         => $request->name,
    //                     'email'        => $request->email,
    //                     'phone'        => $request->phone,
    //                     'isVerified'   => $request->isVerified,
    //                     'roles'        => $request->roles,
    //                     'customers_id' => null,
    //                     'drivers_id'   => $id,
    //                  ]);
    //             }
    //         }

            
    //         $item->update([
    //             'partners_id'  => $request->partners_id,
    //             'name'         => $request->name,
    //             // 'no_anggota'   => $request->no_anggota,
    //             'tarif'        => $request->tarif,
    //             'long'         => $request->long,
    //             'lat'          => $request->lat,
    //             'alamat'       => $request->alamat,
    //         ]);
        
            
    //         // $item->update($data);
    //     } catch (QueryException $e) {
    //         if(\Request::segment(1) == 'api') {
    //             return response([
    //                 'status' => 'error',
    //                 'message' => 'Gagal Disimpan',
    //                 'data' => $item
    //                 // 'status' => $sell_properties
    //             ], 401);
    //         }   
    //         // return back()->with('error', 'Error Update : '.getMessage() );
    //         return back()->with('error', 'Error Update');
    //     }  

    //     if(\Request::segment(1) == 'api') {
    //         $item_new = Coolze_driver::with([
    //             'partner','partner_lengkap','driver_lengkap','order'
    //         ])->where('id', $item->id)->get();
    //         return response([
    //             'status' => 'success',
    //             'message' => 'Berhasil Diedit',
    //             'data' => $item_new
    //             // 'status' => $sell_properties
    //         ], 200);
    //     }
    //     Alert::success('Driver Diupdate', $item_driver->name.' berhasil diupdate');           
    //     return redirect()->route('drivers.index');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $item = Coolze_driver::findOrFail($id);
        $item_driver = Users::where('drivers_id', $id)->first();
        //delete image
        if(File::exists(('storage/'.$item_driver->foto))){
            File::delete('storage/'.$item_driver->foto);            
        }
        
        $item_driver->update([
            'status' => 0,
            'foto'   => null,
        ]);

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item_driver->name,
                'data' => $item_driver
            ], 200);
        }
        Alert::success('Driver Dihapus', $item_driver->name.' berhasil dihapus');        
        return redirect()->route('drivers_withId.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Coolze_driver::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('services-drivers.index');
    }

    public function download($file_name)
    {
        $driver = Coolze_driver::where('file_name', $file_name)->firstOrFail();
        
        $file = 'public/'.$driver->file;
        
        $headers = ['Content-Type: application/pdf'];
    	$newName = 'itsolutionstuff-pdf-file-'.time().'.pdf';
        $pdfku = 'public/assets/gallery/Dzdncsu9J66IRlzEont8YNV7Sv25yCWPLcoUQPf4.jpeg';
        $path = Storage::disk('local')->path($file);
        
        $content = file_get_contents($path);
        return response($content)->withHeaders([
            'Content-Type' => mime_content_type($path)
        ]); 
        
    }

    public function profile($id)
    {
        $content = Coolze_driver::findOrFail($id);
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
        
        $items = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
            ])->where('drivers_id', $id)
            ->where('partners_id', $this->user->id)
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
   
}
