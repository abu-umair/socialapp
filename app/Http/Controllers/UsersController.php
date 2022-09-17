<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersRequest;
use Illuminate\Http\Request;
use App\Users;
use App\Coolze_address;
use App\Coolze_customer;
use App\Adfood_customer;
use App\Coolze_partner;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Crypt;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $items = Users::with([
            'customer'
            ])
            ->where('status', 1)
            ->get();
            
        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Users',
                'data' => $items
                ], 200);
        }

        // $items = Users::all();

        return view('pages.admin.customers-adfood.index', [
            'items' => $items
        ]);

        // return view('pages.admin.users-coolze.index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.users-coolze.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $data = $request->all();
        
        $identifier = Str::random(12);
        $otp =  Otp::setValidity(3)  // otp validity time in mins
                            ->setLength(6)  // Lenght of the generated otp
                            ->setMaximumOtpsAllowed(100) // Number of times allowed to regenerate otps
                            ->setOnlyDigits(false)  // generated otp contains mixed characters ex:ad2312
                            ->setUseSameToken(false) // if you re-generate OTP, you will get same token
                            ->generate($identifier);
        
        $data['password'] = Hash::make($request->password);
        $request->file('foto') != null ? $data['foto'] = $request->file('foto')->store('assets/gallery', 'public') : null;
        $item = Users::create($data);
        try {

            

            //create customer/partner & update user customers_id
            if ($request->jenis_pengguna == 'customer') {
                $users_update = $item->update([
                    'customers_id'         => $item->id,
                ]);
                
                
                $item_cust = Coolze_customer::create([
                'id'            => $item->id,
                'reveral'       => $otp->token,
                ]);

            } elseif ($request->jenis_pengguna == 'mitra') {
                $users_update = $item->update([
                    'partners_id'         => $item->id,
                ]);

                $item_cust = Coolze_partner::create([
                'id'            => $item->id,
                'reveral'       => $otp->token,
                ]);
            }
            
            
            
        } catch (QueryException $e) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $users_update,$item_cust
                ], 401);
            }
            // return back()->with('error', 'Error Create : '.getMessage() );
            return back()->with('error', 'Error Create');
        }    

        if(\Request::segment(1) == 'api') {
            $item_new = Users::with([
                'customer','partner'
            ])->where('id', $item->id)->get();

            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan User',
                'data' => $item_new,
            ], 200);           
        }

        Alert::success('Users Ditambahkan', $item->name.' berhasil ditambahkan');        
        return redirect()->route('users.index');

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
            'customer','partner'
            ])
        ->findOrFail($id);

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'Get User '.$item->name,
                'data' => $item 
                ], 200);
        }

        return view('pages.admin.users.detail', [
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
        $item = Users::with([
            'customer','partner'
            ])
        ->findOrFail($id);
        // $encrypted = Crypt::encryptString($item->password);

        return view('pages.admin.users-coolze.edit', [
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
        $request->validate([
            'current_password'  => 'required',
            'name'              => 'required|max:255',
            'email'             => 'required|max:255',
            'phone'             => 'required',
            // 'email_verified_at' => 'required|max:255',
            'isVerified'        => 'nullable|max:255',            
            'password'          => 'nullable|string|min:6|confirmed',
            'roles'             => 'required|max:30',
            'jenis_pengguna'    => 'required|string|in:mitra,customer',
          ]);
       

        $data = $request->all();
        // dd($data);
        $item = Users::with([
            'customer','partner'
        ])->findOrFail($id);
        
        // update addresses
        if ($request->jenis_pengguna == 'customer') {
            Coolze_address::where('partners_id',$item->id)
                    ->OrWhere('customers_id',$item->id)
                    ->update([
                    'customers_id'=>$item->id,
                    'partners_id'=>null,
                    ]);
        } else {
            Coolze_address::where('partners_id',$item->id)
                    ->OrWhere('customers_id',$item->id)
                    ->update([
                    'partners_id'=>$item->id,
                    'customers_id'=> null,
                    ]);
        }
            

        if (!Hash::check($request->current_password, $item->password)) {
            return back()->with('error', 'Password tidak cocok dengan password lama!');
        }
        
        if($request->password != null && $request->password_confirmation != null){
            $pass = Hash::make($request->password);
        } else{
            $pass = $item->password;
        }
        
        if ($item->customer != null) { //jika adalah customer
            
            $customer = Coolze_customer::findOrFail($item->customer->id);

            $request->file('foto') != null ? $path = $request->file('foto')->store('assets/gallery', 'public') : $path = $item->foto;
            
            //delete image
            if ($request->file('foto') != null) {
                if(File::exists(('storage/'.$item->foto))){
                    File::delete('storage/'.$item->foto);            
                }
            }

            if ($request->jenis_pengguna == 'customer') {
                $users_update = $item->update([

                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                ]);
            }
            elseif($request->jenis_pengguna == 'mitra'){
                $users_update = $item->update([
                    'foto'          => $path,
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
                                'reveral'      => $customer->reveral,
                            ]);
                $customer->delete();
            }

        } elseif ($item->partner != null) { //jika adalah partner
            $partner = Coolze_partner::findOrFail($item->partner->id);

            $request->file('foto') != null ? $path = $request->file('foto')->store('assets/gallery', 'public') : $path = $item->foto;

            //delete image
            if ($request->file('foto') != null) {
                if(File::exists(('storage/'.$item->foto))){
                    File::delete('storage/'.$item->foto);            
                }
            }

            if ($request->jenis_pengguna == 'mitra') {
                $users_update = $item->update([

                    'foto'         => $path,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $pass,
                    'phone'        => $request->phone,
                    'isVerified'   => $request->isVerified,
                    'roles'        => $request->roles,
                ]);
            }
            elseif($request->jenis_pengguna == 'customer'){
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
                'customer','partner'
            ])->findOrFail($id);

            return response([
                'status' => 'success',
                'message' => 'Berhasil Diupdate',
                'data'   => $item_new,
            ], 200);
        }
        
                            
        Alert::success('Users Diupdate', $item->name.' berhasil diupdate');
            return redirect()->route('users.index');            
        // $ygdiLempar= 'test lempar data'
        // return view('namaView','ygdiLempar' => $ygdiLempar);
        
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
            'customer','partner'
        ])
        ->findOrFail($id);
        // $partOrcust = $item->customers_id != null ? Coolze_customer::findOrFail($id) :  Coolze_partner::findOrFail($id);        

        //delete image
        if(File::exists(('storage/'.$item->foto))){
            File::delete('storage/'.$item->foto);            
        }
        $item->update([
            'foto'   => null,
            'status' => 0,
        ]);
        

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'success',
                'message' => 'Berhasil Delete / status = 0,  '.$item->name,
                'data' => $item,
            ], 200);
        }
        
        Alert::success('User Dihapus', $item->name.' berhasil dihapus');

        return redirect()->route('users.index');
    }
}
