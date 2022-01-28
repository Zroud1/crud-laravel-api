<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator ;
use Illuminate\Support\Facades\Hash;


class RegisterController extends BaseController
{
   public function register(Request $request){
       try {
           //code...

    $validator = Validator::make($request->all(),[
        'name' =>'required',
        'email' =>['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' =>'required',
        'c_password' =>'required|same:password',
    ]);

    if ($validator->fails()) {
        return $this->sendError('Please validate error' ,$validator->errors() );
    }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('Muhammed')->accessToken;
        $success['name'] = $user->name;
        $success['email'] = $user->email;

    return $this->sendResponse($success ,'User registered successfully' );
    } catch (\Exception $ex) {
        return $this->sendError('Please validate error' ,$ex->getMessage());

    }
   }


   public function login(Request $request){
    try{
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
    {
        $user = Auth::user();
        $success['api_token'] = $user->createToken('Muhammed')->accessToken;
        $success['name'] = $user->name;
        $success['email'] = $user->email;
        return $this->sendResponse($success ,'User login successfully' );
    }
    else{
        return $this->sendError('Please check your Auth' ,['error'=> 'Unauthorised'] );
    }

    } catch (\Exception $ex) {
        return $this->sendError('Please validate error' ,$ex->getMessage());
    }
   }
}
