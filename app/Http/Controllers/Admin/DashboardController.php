<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coolze_order;
use App\Coolze_package;
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

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        

        $item_users = Users::with([
            'customer','address_cust','order_cust','partner','address','order_part','driver','order_drive'
            ])
            ->where('status', 1)
            ->get();
        
            
        // chart orders
        $month = now()->month;
        $year = now()->year;
        // order all status
        $orders_all_status  = Coolze_order::whereYear('created_at', $year)
            ->get();
        // order all status end
        // orders accept
        $orders_accept_only  = Coolze_order::whereYear('created_at', $year)
                    ->where('status','accept')
                    ->select('id', 'created_at')
                    ->get();
        $orders_accept= $orders_accept_only->groupBy(function($dateAccept) {
                        //return Carbon::parse($dateAccept->created_at)->format('Y'); // grouping by years
                        return \Carbon\Carbon::parse($dateAccept->created_at)->format('m'); // grouping by months
        });
        
        $orderMcountAccept = [];
        $ArrAccept = [];
        
        foreach ($orders_accept as $keyAccept => $valueAccept) {
            $orderMcountAccept[(int)$keyAccept] = count($valueAccept);
        }
        
        
        for($i = 1; $i <= $month; $i++){
            if(!empty($orderMcountAccept[$i])){
                $ArrAccept[$i] = $orderMcountAccept[$i];    
            }else{
                $ArrAccept[$i] = 0;    
            }
        }
        
        $implodeOrderAccept=implode(',',$ArrAccept);
        // orders accept end

        // orders pending
        $orders_Pending_only  = Coolze_order::where('status','pending')
                    ->whereYear('created_at', $year)
                    ->select('id', 'created_at')
                    ->get();
        $orders_Pending = $orders_Pending_only->groupBy(function($datePending) {
                        //return Carbon::parse($datePending->created_at)->format('Y'); // grouping by years
                        return \Carbon\Carbon::parse($datePending->created_at)->format('m'); // grouping by months
        });
        
        
        $orderMcountPending = [];
        $ArrPending = [];
        
        foreach ($orders_Pending as $keyPending => $valuePending) {
            $orderMcountPending[(int)$keyPending] = count($valuePending);
        }
        
        
        for($i = 1; $i <= $month; $i++){
            if(!empty($orderMcountPending[$i])){
                $ArrPending[$i] = $orderMcountPending[$i];    
            }else{
                $ArrPending[$i] = 0;    
            }
        }
        
        $implodeOrderPending=implode(',',$ArrPending);
        // orders pending end

        // orders cancel
        $orders_Cancel_only  = Coolze_order::where('status','cancel')
                    ->whereYear('created_at', $year)
                    ->select('id', 'created_at')
                    ->get();
        $orders_Cancel = $orders_Cancel_only->groupBy(function($dateCancel) {
                        //return Carbon::parse($dateCancel->created_at)->format('Y'); // grouping by years
                        return \Carbon\Carbon::parse($dateCancel->created_at)->format('m'); // grouping by months
        });
        
        
        $orderMcountCancel = [];
        $ArrCancel = [];
        
        foreach ($orders_Cancel as $keyCancel => $valueCancel) {
            $orderMcountCancel[(int)$keyCancel] = count($valueCancel);
        }
        
        
        for($i = 1; $i <= $month; $i++){
            if(!empty($orderMcountCancel[$i])){
                $ArrCancel[$i] = $orderMcountCancel[$i];    
            }else{
                $ArrCancel[$i] = 0;    
            }
        }
        
        $implodeOrderCancel=implode(',',$ArrCancel);
        // chart order end

        // voucher
        $item_vouchers = Coolze_voucher::where('status',1)->get();
        // voucher end

        // packages
        $item_packages = Coolze_package::with([
            'subpackage'
        ])
            ->where('status', 1)
            ->get();
        // packages end

        // lasted orders
        $item_lastedOrders = Coolze_order::with([
            'customer','user_customer','alamat_customer','partner','user_partner','driver','voucher','package','subpackage'
        ])
        ->orderBy('created_at', 'DESC')
        ->take(6)
        ->get();
        // lasted orders

        // contents
        $item_contents = Content::orderBy('created_at', 'DESC')
        ->take(4)
        ->get();
        // contents end
        
        return view('pages.admin.dashboard', [
            'item_users' => $item_users,
            'implodeOrderAccept' => $implodeOrderAccept,
            'orders_accept_only' => $orders_accept_only,
            'implodeOrderPending'=> $implodeOrderPending,
            'orders_Pending_only'=> $orders_Pending_only,
            'implodeOrderCancel' => $implodeOrderCancel,
            'orders_Cancel_only' => $orders_Cancel_only,
            'orders_all_status'  => $orders_all_status,
            'item_vouchers'      => $item_vouchers,
            'item_packages'      => $item_packages,
            'item_lastedOrders'  => $item_lastedOrders,
            'item_contents'      => $item_contents,
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
