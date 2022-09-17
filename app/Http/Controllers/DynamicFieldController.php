<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Doctor;
use App\Ongoing;
use App\Service;
//dynamic input
use App\DynamicField;
use Validator;
//dynamic input
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\DoctorRequest;
use Illuminate\Support\Facades\Storage;
use Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DynamicFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
     return view('pages.dynamic_field');
    }

    function insert(Request $request)
    {
     if($request->ajax())
     {
      $rules = array(
       'first_name.*'  => 'required',
    //    'last_name.*'  => 'required'
      );
      $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      $first_name = $request->first_name;
    //   $last_name = $request->last_name;
      for($count = 0; $count < count($first_name); $count++)
      {
       $data = array(
        'first_name' => $first_name[$count],
        // 'last_name'  => $last_name[$count]
       );
       $insert_data[] = $data; 
      }

      DynamicField::insert($insert_data);
      return response()->json([
       'success'  => 'Data Added successfully.'
      ]);
     }
    }
}
