<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Coolze_customer;
use App\Coolze_partner;
use App\Coolze_address;
use App\Partner;
use App\Ongoing;
use App\User;
use App\Coolze_order;
use App\Users;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\PartnerRequest;
use Illuminate\Support\Facades\Hash;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Users::with([
            'partner','address','order_part'
            ])
            ->where('partners_id','!=', null)
            ->where('status', 1)
            ->get();
        
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Mitra / Partners',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.partners-coolze.index', [
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
        return view('pages.admin.partners-coolze.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerRequest $request)
    {
        $jenis_pengguna = 'mitra';
        $request->validate([
            'email'             => 'unique:users',
            'phone'             => 'unique:users',
        ]);
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(), 400);
        // }
        $data = $request->all();

        $identifier = Str::random(12);
        $otp =  Otp::setValidity(3)  // otp validity time in mins
                            ->setLength(6)  // Lenght of the generated otp
                            ->setMaximumOtpsAllowed(100) // Number of times allowed to regenerate otps
                            ->setOnlyDigits(false)  // generated otp contains mixed characters ex:ad2312
                            ->setUseSameToken(false) // if you re-generate OTP, you will get same token
                            ->generate($identifier);
        
        $data['password'] = Hash::make($request->password);
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : $data['foto'] = null;
        $item = Users::create($data);
        
        try {
            
            //create customer/partner & update user customers_id
            if ($jenis_pengguna == 'customer') {
                $users_update = $item->update([
                    'customers_id'         => $item->id,
                ]);
                
                
                $item_cust = Coolze_customer::create([
                'id'            => $item->id,
                // 'foto'          => $path,
                'jumlah_ac'     => $request->jumlah_ac,
                'reveral'       => $otp->token,
                ]);

            } elseif ($jenis_pengguna == 'mitra') {
                $users_update = $item->update([
                    'partners_id'         => $item->id,
                ]);

                // $request->file('foto') != null ? $path = $request->file('foto')->store('assets/gallery', 'public') : $path = null;
                $item_cust = Coolze_partner::create([
                'id'            => $item->id,
                // 'foto'          => $path,
                'reveral'       => $otp->token,
                ]);
            }

        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data Mitra' => $item,
                ], 401);
            }

            return back()->with('error', 'Error Create');
            // return back()->with('error', 'Error Create');
        }    

        if(\Request::segment(1) == 'api') {
            $item_new = Users::with([
                'partner'
            ])->where('id', $item->id)->get();
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Mitra',
                'data Mitra' => $item_new,
            ], 200);           
        }
        Alert::success('Partner / Mitra Ditambahkan', $item->name.' berhasil ditambahkan');           
        return redirect()->route('partners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Users::with([
            'partner'
            ])
        ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get Mitra '.$item->name,
                'data' => $item 
                ], 200);
        }

        // return view('pages.admin.users-customer.detail', [
        //     'item' => $item
        // ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Users::with([
            'partner'
        ])->findOrFail($id);

        return view('pages.admin.partners-coolze.edit', [
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
    public function update(Request $request, $id)
    {
        $jenis_pengguna = 'mitra';
        
        $request->validate([
            
            'name'              => 'required|max:255',
            'email'             => 'required|max:255',
            'phone'             => 'required',
            // 'email_verified_at' => 'required|max:255',
            'isVerified'        => 'nullable|max:255',            
            'password'          => 'nullable|string|min:6|confirmed',
            'roles'             => 'required|max:30',
            'foto'              => 'image',
          ]);
       

        // $data = $request->all();
        $item = Users::with([
            'partner'
        ])->findOrFail($id);
        

        $request->file('foto') != null ? $path = $request->file('foto')->store('assets/gallery', 'public') : $path = $item->foto;

        //delete image
        if ($request->file('foto') != null) {
            if(File::exists(('storage/'.$item->foto))){
                File::delete('storage/'.$item->foto);            
            }
        }

        if($request->password != null && $request->password_confirmation != null){
            $pass = Hash::make($request->password);
        } else{
            $pass = $item->password;
        }
        
        if ($item->customer != null) { //jika adalah customer
            
            $customer = Coolze_customer::findOrFail($item->customer->id);

            if ($jenis_pengguna == 'customer') {
                $users_update = $item->update([
                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                    
                ]);
                $customer->update([
                    // 'foto'          => $path,
                    'jumlah_ac'     => $request->jumlah_ac,
                        
                ]);
            }
            elseif($jenis_pengguna == 'mitra'){
                $users_update = $item->update([
                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                    'customers_id' => null,
                    'partners_id'  => $item->id,
                ]);

                $partner = Coolze_partner::create([
                                'id'           => $item->id,
                                // 'foto'         => $path,
                                'reveral'      => $customer->reveral,
                            ]);

                $customer->delete();
            }

        } elseif ($item->partner != null) { //jika adalah partner
            $partner = Coolze_partner::findOrFail($item->partner->id);

            if ($jenis_pengguna == 'mitra') {
                $users_update = $item->update([
                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                ]);
                // $partner->update([
                //     'foto'          => $path,
                        
                // ]);
            }
            elseif($jenis_pengguna == 'customer'){
                $users_update = $item->update([
                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                    'customers_id' => $item->id,
                    'partners_id'  => null,
                ]);

                $customer = Coolze_customer::create([
                                'id'           => $item->id,
                                // 'foto'         => $path,
                                'reveral'      => $partner->reveral,
                            ]);
                $partner->delete();
            }
        }
        
        try {
            
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Diupdate',
                    // 'data lengkap customer'=>$item_cust
                ], 401);
            }
            return back()->with('error', 'Error Update');
        }  

        if(\Request::segment(1) == 'api') {
            $item_new = Users::with([
                'partner'
            ])->findOrFail($id);

            return response([
                'status' => 'success',
                'message' => 'Berhasil Diupdate',
                'data'   => $item_new,
            ], 200);
        }
        Alert::success('Mitra Diupdate', $item->name.' berhasil diupdate');            
        return redirect()->route('partners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Users::with([
            'partner'
        ])
        ->findOrFail($id);
        // $partOrcust = Coolze_customer::findOrFail($id) ;        
        // $partOrcust = Coolze_partner::findOrFail($id);

        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }

        $item->update([
            'foto'   => null,
            'status' => 0,
        ]);
        // $item->delete();
        // $partOrcust->delete();

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete '.$item->name,
                'data' => $item,
            ], 200);
        }
        Alert::success('Partner Didelete', $item->name.' berhasil didelete');                
        return redirect()->route('partners.index');
    }

    public function restore()
    {
        // Alert::success('Berhasil menghapus data !')->persistent('Confirm');
        $resore_Soft_Delete = Partner::onlyTrashed();
        $resore_Soft_Delete->restore();
        // if(\Request::segment(1) == 'api') {
        //     return response()->json($resore_Soft_Delete, 200);
        // }
        // Alert::warning('Success Title','Success Restore ')->persistent('Close');
        return redirect()->route('users-customer.index');
    }

    public function profile($id)
    {
        $user = Users::with([
            'partner','customer', 
            ])->findOrFail($id);
        // $ongoings = Ongoing::with([
        //     'user','customer', 'doctor', 'groomer'
        //     ])->where('customers_id', $id)
        //         // ->where('acc', '!=', null)
        //         ->orderBy('created_at', 'DESC')
        //         ->get();
        
        // $ongoings = Ongoing::with([
        //     'user','customer',
        //     ])->where('customers_id', $id)
        //         // ->where('acc', '!=', null)
        //         ->orderBy('created_at', 'DESC')
        //         ->get();

            if(\Request::segment(1) == 'api') {
                return response()->json([
                    'success' => true,
                    'message' => 'List Semua Profile',
                    'data' => $user
                    ], 200);
            }
            
            $user->partner != null ? $cust_part = $user->partner : $cust_part = $user->customer;
        return view('pages.admin.profile-coolze.index', [
            'user' => $user,
            'cust_part' => $cust_part,
        ]);
        
        
    }

    public function transaksi($id)
    {
        
        $items = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
            ])->where('partners_id', $id)
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
