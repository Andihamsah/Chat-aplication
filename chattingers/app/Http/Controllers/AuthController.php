<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
        public function register(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'telp' => 'required|numeric'
            ]);
    
            if($validator->fails())
            {
                return response()->json([

                    'errors' => $validator->errors()->toJson(),'status' => 400

                    

                ]);
            }

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'avatar' => $request->avatar,
                    'telp' => $request->telp,
                    
                ]);
            $token = auth()->login($user);
            $get = User::where('name',$request->name);
            $id = $get->first();
            return $this->respondWithToken($token,$id->id);


        }


        public function login(Request $request)
        {

            $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'password' => 'required|unique:users',
                
            ]);

            
            if ($validator->fails()) 
            {
                return response()->json($validator->errors()->toJson(),400);
            }

            $credentials = $request->only(['name', 'password']);

            if (!$token = auth()->attempt($credentials)) 
            {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            $get = User::where('name',$request->name);
            $id = $get->first();
            
            return $this->respondWithToken($token,$id);         


        }

        protected function respondWithToken($token,$id)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,

                'user' => $id
            ]);
        }

        public function index($id)
        {
            return response()->json(User::find($id));
        }

        public function show()
        {
            return response()->json(User::all());
        }


        public function updateavatar(Request $req)
        {            
            // dd($req);
            $send = User::find($req->id);  
            $send->avatar = $req->input('avatar');
            if ($send->save()) {
                return response()->json(['exception' => 'succes']);
            }
            return response()->json(['exception' => 'fail']);
        }

        // public function updateuser(Request $req)
        // {
        //     if (isset($req->name) && is_null($req->email) && is_null($req->avatar) && is_null($req->telp)) {
        //         $send = User::where('name',$req->name);
        //         $send->name = $req->input('name');
        //         if (!$send->save()) {
        //             return response()->json(['exception' => "fail"]);
        //         }
        //         return response()->json(['exception' => "success"]);
        //     }
        //     elseif (is_null($req->name) && isset($req->email) && is_null($req->avatar)  && is_null($req->telp)) {
        //         $send = User::where('email',$req->email);
        //         $send->email = $req->input('email');
        //         if (!$send->save()) {
        //             return response()->json(['exception' => "fail"]);
        //         }
        //         return response()->json(['exception' => "success"]);
        //     }
        //     elseif (is_null($req->name) && is_null($req->email) && isset($req->avatar) && is_null($req->telp)) {
        //         $send = User::where('avatar',$req->avatar);
        //         $send->avatar = $req->input('avatar');
        //         if (!$send->save()) {
        //             return response()->json(['exception' => "fail"]);
        //         }
        //         return response()->json(['exception' => "success"]);
        //     }
        //     elseif (is_null($req->name) && is_null($req->email) && is_null($req->avatar) && isset($req->telp)) {
        //         $send = User::where('telp',$req->telp);
        //         $send->telp = $req->input('telp');
        //         if (!$send->save()) {
        //             return response()->json(['exception' => "fail"]);
        //         }
        //         return response()->json(['exception' => "success"]);
        //     }            
        //     elseif (isset($req->name) && isset($req->email) && isset($req->avatar) && isset($req->telp)) {
        //         dd($req);
        //     } 
        //     $send = User::find($req->id);
        //     $send->name = $req->input('name');
        //     $send->email = $req->input('email');
        //     $send->password = $req->input('password');
        //     $send->avatar = $req->input('avatar');
        //     $send->telp = $req->input('telp');
        //     if ($send->save()) {
        //         return response()->json(['exception' => 'berhasil di edit']);
        //     }
        //     return response()->json(['exception' => 'error']);
        // }  

}
