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
                    'errors' => $validator->errors()->toJson(), 400
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'telp' => $request->telp
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
            return $this->respondWithToken($token,$id->id);

        }

        protected function respondWithToken($token,$id)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user_id' => $id,
            ]);

        }

        public function edit(Request $request)
        {
            $update = User::find($request->id);
            $update->avatar = $request->input('avatar');
            if (!$update->save()) {
                return response()->json(['message' => 'Avatar can not sended. please contact to backend for more information']);
            }
            $get_avatar = User::find($request->id);
            $avatar = $get_avatar->avatar;
            return response()->json([
                'message' => 'Avatar has been update',
                'files' => $avatar
            ]);
        }

        


    
}
