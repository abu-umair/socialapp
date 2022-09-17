<?php

namespace App\Observers;

use App\User;
use App\Adfood_customer;
use App\Adfood_merchant;
use App\Coolze_customer;
use App\Coolze_driver;
use App\Coolze_partner;
use Illuminate\Support\Str;
use Seshac\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserObserver
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {                
        if ($this->request->roles == 'user' || $this->request->roles == 'USER') {
            $user->update(['customers_id'=> $user->id]); 
            Adfood_customer::create([
                'id'      => $user->id,
                'address' => $this->request->address,
                'long'    => $this->request->long,
                'lat'     => $this->request->lat,
            ]);
        } elseif ($this->request->roles == 'merchant' || $this->request->roles == 'MERCHANT'){
            $user->update(['merchants_id'=> $user->id]);
            Adfood_merchant::create([
                'id'                   => $user->id,
                'address'              => $this->request->address,
                'long'                 => $this->request->long,
                'lat'                  => $this->request->lat,
                'type_business'        => $this->request->type_business,
                'phone_restaurant'     => $this->request->phone_restaurant,
            ]);
        } 
        // Customer::create(['name' => 'aaa']);

    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        // $user->update(['customers_id'=>'20']);
        // User::update([
        //     'customers_id'=>'20'
        //     ]);
        // $user->customers_id = '3';
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
