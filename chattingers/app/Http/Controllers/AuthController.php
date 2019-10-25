<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Sender;
use App\Receiver;
use App\Friend;
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
                    'avatar' => asset('img/defaultAvatar.svg'),
                    'telp' => $request->telp,
                ]);
            
            $token = auth()->login($user);
            $get = User::where('name',$request->name);
            $user = $get->first();
            return $this->respondWithTokenOnRegister($token,$user->id);


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
            $user = User::whereNotIn('name',[$request->name])->get();                       
            $login = User::where('name',$request->name)->get();
            $login = $login->first();
            return $this->respondWithToken($token,$user,$login);
        }    


        protected function respondWithToken($token,$user,$login)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'login' => $login,
                'user' => $user
            ]);
        }

        protected function respondWithTokenOnRegister($token,$user)
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
            $image->avatar = $req->avatar;
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
            if (isset($req->id) && isset($req->name) && isset($req->email) && isset($req->telp) && is_null($req->avatar)) {
                $send = User::find($req->id);
                $send->name = $req->name;
                $send->email = $req->email;
                $send->telp = $req->telp;
                if ($send->save()) {
                    return response()->json(['exception' => 'berhasil di edit']);
                }
                return response()->json(['exception' => 'salah aldy']);                
            }
            elseif (isset($req->id) && is_null($req->name) && is_null($req->email) && is_null($req->telp) && isset($req->avatar)) {
                $send = User::find($req->id);
                $send->avatar = base64_encode($req->avatar);            
                if ($send->save()) {
                    return response()->json(['exception' => 'berhasil di edit']);
                }
                return response()->json(['exception' => 'error']);
            }
                        
        }

        public function privasi(Request $req)
        {
            $send = User::find($req->id);
            $send->password = bcrypt($req->input('password'));
            if ($send->save()) {
                return response()->json(['exception' => 'berhasil di edit']);
            }
            return response()->json(['exception' => 'error']);
        }

        public function registerDemo()
        {
            return view('chat.register');
        }
        public function loginDemo()
        {
            return view('chat.login');
        }

        public function storeDemo(Request $request)
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
            return view('chat.login');


        }

        public function loginDemoSend(Request $request)
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
            
            $user = User::whereNotIn('name',[$request->name])->get();
            $get_login = User::where('name',$request->name)->get();
            $user_login = $get_login->first();
            $id = $user_login->id;
            
            return view('chat.index',compact('id','user'));     
            }

            public function demoChat($sender_id, $receiver_id)
            {
            
                $sender = Sender::where('sender_id',$sender_id)
                        ->where('receiver_id',$request->receiver_id)->get();
                
                $receiver = Receiver::where('receiver_id',$receiver_id)
                                    ->where('sender_id',$sender_id)->get();
                $receiver_id = $receiver_id;
                $sender_id = $sender_id;
                return view('chat.chat',compact('sender','receiver','receiver_id','sender_id'));
            }

            public function demoSendChat(Request $request)
            {
                            // if all data have an value
                    if ($request->text !== null && $request->files !== null) {
                    
                        $send = new Sender;
                        $send->text = $request->input('text');
                        $send->files = $request->input('files');
                        $send->sender_id = $request->input('sender_id');
                        $send->receiver_id = $request->input('receiver_id');
                            
                
                        $receive = new Receiver;
                        $receive->text = $request->input('text');
                        $receive->files = $request->input('files');
                        $receive->receiver_id = $request->input('sender_id');
                        $receive->sender_id = $request->input('receiver_id');

                        

                        if (!$receive->save() && !$send->save()) {
                            return response()->json(['message' => 'Data failed be saved to Receiver table and Sender table']);
                        }
                        elseif (!$receive->save() || !$send->save()) {
                            return response()->json(['message' => 'Data failed be saved to Receiver table or Sender table']);
                        }
                        else {
                            $sender = Sender::where('sender_id',$request->sender_id)
                            ->where('receiver_id',$request->receiver_id)->get();
                            
                            $receiver = Receiver::where('receiver_id',$request->receiver_id)
                                                ->where('sender_id',$request->sender_id)->get();
                            $receiver_id = $request->receiver_id;
                            $sender_id = $request->sender_id;
                            return view('chat.chat',compact('sender','receiver','receiver_id','sender_id'));
                        }


                    }

                    // if all data sended has null value 
                    else {
                        return response()->json(['message' => 'Message must not empty']);
                    }
            }


        public function addFriend($id_login, $friend_id) {
            $friend = User::find($friend_id);
            $user = User::find($id_login);
            $add = new Friend;
            $add->name = $friend->name;
            $add->email = $friend->email;
            $add->avatar = $friend->avatar;
            $add->password = $friend->password;
            $add->friend_id = $friend->id;
            $add->telp = $friend->telp;
            $add->user_id = $id_login;
            if (!$add->save()) {
                return response()->json(['message' => 'Failed to add friend please call customer services for fix this happens'],500);

            }

            return response()->json(['message' => 'Friend succesfully added']);

        }

        public function getFriend($id)
        {
            $friend = Friend::where('user_id',$id)->get();

            if ($friend->count() == null) {
                return response()->json(['friend' => '']);
            }

            return response()->json([
                'friend' => $friend
            ]);
        }
        
        public function unfriend($id,$user_id)
        {
            $friend = Friend::where('id', $id)
                            ->where('user_id', $user_id);
            if ($friend->delete()) {
                return response()->json(['message' => ""]);
            }
            return response()->json(['message' => "fail delete"]);
        }

}
