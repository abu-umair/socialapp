<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Ongoing;
use App\Customer;
use App\Doctor;
use App\Groomer;
use App\User;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Users;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $items = Ongoing::with([
            'user','customer', 'doctor', 'groomer'
            ])
        ->where('acc', null)
        ->orderBy('created_at', 'DESC')
        ->take(5)
        ->get();

        foreach ($items as $item_lengkap) {
            $item_sempurna =$item_lengkap->user;
            
            // dd($item_lengkap);
        }
        foreach ($items as $item_doctor) {
            // $item_sempurna =$item_doctor->customer->user;
            $item_doctor =$item_doctor->doctor;
           
            // dd($item_lengkap);
        }
        foreach ($items as $item_groomer) {
            // $item_sempurna =$item_groomer->customer->user;
            $item_groomer =$item_groomer->groomer;
            
            // dd($item_lengkap);
        }

        return view('pages.admin.dashboard', [
            'items' => $items,
        ]);
    }

    public function allNotif()
    {
        return view('pages.admin.notification');
    }

    public function updatenotification(Request $request, $rules_now)
    {
        if ($rules_now == 'admin') {
            $notif = Notification::where('read_at', null)
                        // ->where('partners_id', 33)
                        ->update([
                        'read_at'=> Carbon::now()
                    ]);
                    return response()->json([
                        'status'=>200,
                        'message'=>'Successfully Count.'.$rules_now,
                    ]);
        } elseif($rules_now == 'partner') {
            $notif = Notification::where('read_at_partner', null)
                        ->where('partners_id', Auth::user()->id)
                        ->update([
                        'read_at_partner'=> Carbon::now()
                    ]);
                    return response()->json([
                        'status'=>200,
                        'message'=>'Successfully Count.'.$rules_now,
                    ]);
        }
        
        
    }

    
}
