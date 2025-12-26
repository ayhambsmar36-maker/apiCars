<?php

namespace App\Http\Controllers\Auth;

use App\helper\Api;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  $validated=Validator::make($request->all(),[
        'email'=>"required|string|email|unique:users,email",
        'password'=>"required|string|min:8|max:40|confirmed",
        'name'=>"required|string|min:3|max:40"
    ]);
    if($validated->fails()){
        return Api::responseApi(400,$validated->errors());
    }
    $validated=$validated->validated();
    $user=User::create(['name'=>$validated['name'],'email'=>$validated['email'],'password'=>$validated['password'],'role_id'=>2]);
    return Api::responseApi(201,'register is success',new UserResource($user));
    }

  
}
