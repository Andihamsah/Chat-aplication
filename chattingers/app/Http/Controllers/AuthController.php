<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
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
            $user = $get->first();
            return $this->respondWithToken($token,$user->id);


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
            
            $get = User::where('name',$request->name)->get();                       
            $user = $get->first();            
            // $password = $user->password;
            // $decrypted = Crypt::decryptString($encrypted);
            // dd($password);
            
            return $this->respondWithToken($token,$user);         


        }

        protected function respondWithToken($token,$user)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,

                'user' => $user
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
            $image = User::find($req->id);
            $image->avatar = $req->avatar;  // your base64 encoded
            // $image = str_replace('data:image/png;base64,', '', $image);
            // $image = str_replace(' ', '+', $image);
            // $imageName = str_random(10).'.'.'png';
            // \File::put(storage_path(). '/' . $imageName, base64_decode($image));
            if ($image->save()) {
                return response()->json(['exception' => 'succes']);
            }
            return response()->json(['exception' => 'fail']);
        }

        public function updateuser(Request $req)
        {        
            $send = User::find($req->id);
            $send->name = $req->input('name');
            $send->email = $req->input('email');            
            $send->telp = $req->input('telp');
            if ($send->save()) {
                return response()->json(['exception' => 'berhasil di edit']);
            }
            return response()->json(['exception' => 'error']);
        }

        public function mobileupdate(Request $req)
        {
            $send = User::find($req->id);
            if (isset($req->name) && isset($req->email) && isset($req->telp) && is_null($req->avatar)) {
                $send->name = $req->name;
                $send->email = $req->email;            
                $send->telp = $req->telp;
                if ($send->save()) {
                    return response()->json(['exception' => 'berhasil di edit']);
                }
                return response()->json(['exception' => 'error']);                
            }
            elseif (is_null($req->name) && is_null($req->email) && is_null($req->telp) && isset($req->avatar)) {
                $send->avatar = $req->avatar;
                if ($send->save()) {
                    return response()->json(['exception' => 'berhasil di edit']);
                }
                return response()->json(['exception' => 'error']);
            }
                            
        }

        public function privasi(Request $req)
        {
            $send = User::find($req->id);
            $send->password = $req->input('password');
            if ($send->save()) {
                return response()->json(['exception' => 'berhasil di edit']);
            }
            return response()->json(['exception' => 'error']);
        }

}
