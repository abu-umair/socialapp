<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coolze_order;
use App\Adfood_reservation;
use App\Adfood_stripe;
use App\Coolze_package;
use App\Adfood_food;
use App\Adfood_ori_vouchers;
use App\Coolze_partner;
use App\Coolze_customer;
use App\Groomer;
use App\Content;
use App\User;
use App\Users;

use App\Coolze_voucher;
use App\Service;
use Illuminate\Support\Str;
// use App\Helpers\StringHelper;
use Illuminate\Http\Request;

class DashboardAdfoodController extends Controller
{
    public function index(Request $request)
    {
        

        $item_users = Users::where('status', 1)
            ->get();
            
        // chart reservation
        $month = now()->month;
        $year = now()->year;
        // reservation all status
        $reservation_all_status = Adfood_reservation::whereYear('created_at', $year)
            ->get();
        // order all status end
        // reservations accept
        $reservation_accept_only  = Adfood_reservation::whereYear('created_at', $year)
                    ->where('status','accepted')
                    ->select('id', 'created_at')
                    ->get();
        $reservation_accept= $reservation_accept_only->groupBy(function($dateAccept) {
                        //return Carbon::parse($dateAccept->created_at)->format('Y'); // grouping by years
                        return \Carbon\Carbon::parse($dateAccept->created_at)->format('m'); // grouping by months
        });
        
        $reservationMcountAccept = [];
        $ArrAccept = [];
        
        foreach ($reservation_accept as $keyAccept => $valueAccept) {
            $reservationMcountAccept[(int)$keyAccept] = count($valueAccept);
        }
        
        
        for($i = 1; $i <= $month; $i++){
            if(!empty($reservationMcountAccept[$i])){
                $ArrAccept[$i] = $reservationMcountAccept[$i];    
            }else{
                $ArrAccept[$i] = 0;    
            }
        }
        
        $implodeOrderAccept=implode(',',$ArrAccept);
        // reservations accept end

        // reservations pending
        $reservation_Pending_only  = Adfood_reservation::where('status','pending')
                    ->whereYear('created_at', $year)
                    ->select('id', 'created_at')
                    ->get();
        $reservation_Pending = $reservation_Pending_only->groupBy(function($datePending) {
                        //return Carbon::parse($datePending->created_at)->format('Y'); // grouping by years
                        return \Carbon\Carbon::parse($datePending->created_at)->format('m'); // grouping by months
        });
        
        
        $reservationMcountPending = [];
        $ArrPending = [];
        
        foreach ($reservation_Pending as $keyPending => $valuePending) {
            $reservationMcountPending[(int)$keyPending] = count($valuePending);
        }
        
        
        for($i = 1; $i <= $month; $i++){
            if(!empty($reservationMcountPending[$i])){
                $ArrPending[$i] = $reservationMcountPending[$i];    
            }else{
                $ArrPending[$i] = 0;    
            }
        }
        
        $implodeOrderPending=implode(',',$ArrPending);
        // reservations pending end

        // reservations rejected
        $reservation_Rejected_only  = Adfood_reservation::where('status','rejected')
                    ->whereYear('created_at', $year)
                    ->select('id', 'created_at')
                    ->get();
        $reservation_Rejected = $reservation_Rejected_only->groupBy(function($dateRejected) {
                        //return Carbon::parse($dateRejected->created_at)->format('Y'); // grouping by years
                        return \Carbon\Carbon::parse($dateRejected->created_at)->format('m'); // grouping by months
        });
        
        
        $reservationMcountRejected = [];
        $ArrRejected = [];
        
        foreach ($reservation_Rejected as $keyRejected => $valueRejected) {
            $reservationMcountRejected[(int)$keyRejected] = count($valueRejected);
        }
        
        
        for($i = 1; $i <= $month; $i++){
            if(!empty($reservationMcountRejected[$i])){
                $ArrRejected[$i] = $reservationMcountRejected[$i];    
            }else{
                $ArrRejected[$i] = 0;    
            }
        }
        
        $implodeOrderRejected=implode(',',$ArrRejected);
        // chart order end

        // voucher
        $item_vouchers = Coolze_voucher::with([
            'gallery','merchant'
        ])
        ->where('status',1)->get();
        // voucher end

        // Foods
        $item_foods = Adfood_food::with([
            'merchant'
            ])
            ->where('status', 1)
            ->has('merchant')
            ->take(6)
            ->orderBy('created_at', 'DESC')
            ->get();
        // Foods End
        
        // Promotons /ori_voucher
        $item_promtions = Adfood_ori_vouchers::with([
            'merchant'
        ])
        ->has('merchant')
        ->orderBy('created_at', 'desc')
        ->where('status', 1)
        ->take(6)
        ->get();
        // Promotons /ori_voucher end

        // stripes
        $item_stripes = Adfood_stripe::all();
        // stripes End

        // lasted reservations
        $item_lastedReservations = Adfood_reservation::orderBy('created_at', 'DESC')
        ->take(6)
        ->get();
        // lasted reservations

        // contents
        $item_contents = Content::orderBy('created_at', 'DESC')
        ->take(4)
        ->get();
        // contents end
        
        return view('pages.admin.dashboard-adfood', [
            'item_users'                => $item_users,
            'implodeOrderAccept'        => $implodeOrderAccept,
            'reservation_accept_only'   => $reservation_accept_only,
            'implodeOrderPending'       => $implodeOrderPending,
            'reservation_Pending_only'  => $reservation_Pending_only,
            'implodeOrderRejected'      => $implodeOrderRejected,
            'reservation_Rejected_only' => $reservation_Rejected_only,
            'reservation_all_status'    => $reservation_all_status,
            'item_vouchers'             => $item_vouchers,
            'item_lastedReservations'   => $item_lastedReservations,
            'item_foods'                => $item_foods,
            'item_promtions'            => $item_promtions,
            'item_stripes'              => $item_stripes,
            'item_contents'             => $item_contents,
        ]);
    }

    // my search navbar
    public function search(Request $request)
    {
        $inputSearch = $request['inputSearch'];
        // $keyOngoing = Ongoing::where('id_unique', 'LIKE', '%'.$inputSearch.'%')
        //     // ->OrWhere('description', 'LIKE', '%'.$inputSearch.'%')
        //     ->get();
        // $keyDoctor = Doctor::where('name', 'LIKE', '%'.$inputSearch.'%')
        // ->get();

        // $keyGroomer = User::where('name', 'LIKE', '%'.$inputSearch.'%')
        // ->get();

        $keyCustomer = User::where('name', 'LIKE', '%'.$inputSearch.'%')
        ->get();


        // $keyResultAll = $keyOngoing->merge($keyDoctor);
        // $keyResultAll = $keyResultAll->merge($keyGroomer);
        // $keyResultAll = $keyResultAll->merge($keyCustomer);
        $keyResultAll = $keyCustomer; 
        
        echo $keyResultAll;
    }

    
}
