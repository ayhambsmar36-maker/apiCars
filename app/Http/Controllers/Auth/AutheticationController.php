<?php

namespace App\Http\Controllers\Auth;

use App\helper\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AutheticationController extends Controller
{
  
    public function store(Request $request)
    {
        $validated= Validator::make($request->all(),[
            "email"=>"required|string|email",
            "password"=> "required|string|min:8|max:40",
        ]);
        if($validated->fails()){
            return Api::responseApi(400, $validated->errors());
        }
        $validated= $validated->validated();
        if(Auth::attempt(["email"=> $validated["email"],"password"=> $validated["password"]])){
          $user=User::where("email", $validated["email"])->first();
          $token=$user->createToken("auth-token")->plainTextToken;
          return Api::responseApi(201,'login in is successfully ',['token'=>$token,'user'=>new UserResource($user)]);
    }
    return Api::responseApi(400,'email or password incorrect or not found',[]);
}

  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
