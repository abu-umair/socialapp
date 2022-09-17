<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Kreait\Firebase;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;


class FirebaseController extends Controller
{
    protected $auth, $database;
    public function __construct()
    {
        $factory = (new Factory)
        // ->withServiceAccount(__DIR__.'/FirebaseKey.json')
        ->withDatabaseUri('https://laravelcuddl-default-rtdb.firebaseio.com/');

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    public function set(){
         
        // before
        $ref = $this->database->getReference('hewan')->getValue();
        dump($ref);

        // set data
        $ref = $this->database->getReference('hewan/karnivora')
        ->set([
            "harimau" => [
                "benggala" => "galak",
                "sumatera" => "jinak"
            ]
        ]);

        // after
        $ref = $this->database->getReference('hewan')->getValue();
        dump($ref);
    }

    public function read()
    {
        $ref = $this->database->getReference('hewan/karnivora/harimau')->getSnapshot();
        dump($ref);
        $ref = $this->database->getReference('hewan/karnivora')->getValue();
        dump($ref);
        // $ref = $this->database->getReference('hewan/karnivora')->getValue();
        // dump($ref);
        $ref = $this->database->getReference('hewan/karnivora/harimau')->getSnapshot()->exists();
        dump($ref);
    }

    public function update()
    {
        // before
        $ref = $this->database->getReference('hewan/karnivora')->getValue();
        dump($ref);

        // update data
        $ref = $this->database->getReference('hewan/karnivora/harimau')
        ->update(["benggala" => "sudah gak galak"]);

        // after
        $ref = $this->database->getReference('hewan/karnivora')->getValue();
        dump($ref);
    }

    public function delete()
    {
        // before
        $ref = $this->database->getReference('hewan/karnivora/harimau')->getValue();
        dump($ref);

        /**
         * 1. remove()
         * 2. set(null)
         * 3. update(["key" => null])
         */

        // remove()
        // $ref = $this->database->getReference('hewan/karnivora/harimau/benggala')->remove();

        // set(null)
        // $ref = $this->database->getReference('hewan/karnivora/harimau/benggala')
        //     ->set(null);

        // update(["key" => null])
        $ref = $this->database->getReference('hewan/karnivora/harimau')
            ->update(["benggala" => null]);

        // after
        $ref = $this->database->getReference('hewan/karnivora/harimau')->getValue();
        dump($ref);
    }
}
