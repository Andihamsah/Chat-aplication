<?php

namespace App\Http\Controllers;

use App\Sender;
use Illuminate\Http\Request;
use App\Receiver;
use App\User;
use App\Chat;
use App\Friend;
use App\Events\MyEvent;

use Illuminate\Support\Facades\Validator;
class chatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        $friend = User::whereNotIn('id',[$id])->get();
        
        // $user = User::find($id);
        return response()->json($friend);

    }

    public function search(Request $req)
    {
        if ($req->has('cari')) {          
            $search = User::whereNotIn('id', [$req->id])
                            ->where("name", "LIKE", "%".$req->cari."%")->get();
            return response()->json($search);
        }else {
            return response()->json(['massage' => '']);
        }
        
    }
    
    public function store(Request $request)
    {

        // if all data have an value
        if ($request->text !== null && $request->files !== null) {
        
            //insert data to table sender
            $send = new Sender;
            $send->text = $request->input('text');
            $send->files = $request->input('files');
            $send->sender_id = $request->input('sender_id');
            $send->receiver_id = $request->input('receiver_id');
                
            // insert data to table receiver
            $receive = new Receiver;
            $receive->text = $request->input('text');
            $receive->files = $request->input('files');
            //sender_id input to column receiver_id
            $receive->receiver_id = $request->input('sender_id');
            //receiver_id input to column sender_id
            $receive->sender_id = $request->input('receiver_id');

            
            //save data receiver and sender
            if (!$receive->save() && !$send->save()) {
                return response()->json(['message' => 'Data failed be saved to Receiver table and Sender table']);
            }
            elseif (!$receive->save() || !$send->save()) {
                return response()->json(['message' => 'Data failed be saved to Receiver table or Sender table']);
            }
            else {
                return response()->json(['message' => 'Message succesfully sended']);
            }


        }

        // if all data sended has null value 
        else {
            return response()->json(['message' => 'Message must not empty']);
        }

    }


    public function show($sender_id,$receiver_id)
    { 
        //for show data from table sender by sender_id and receiver_id
        $sender = Sender::where('sender_id',$sender_id)
                        ->where('receiver_id',$receiver_id)->get();
        
        // for show data from table receiver by receiver_id and sender_id
        $receiver = Receiver::where('receiver_id',$receiver_id)
                            ->where('sender_id',$sender_id)->get();
        
        
        return response()->json([
            'sender' => $sender,
            'receiver' => $receiver
        ]);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sender_update = Sender::find($request->id);
        $sender_update->text = $request->input('text');
        $sender_update->files = $request->input('files');
        $receive_update = Receiver::find($request->id);
        $receive_update->text = $request->input('text');
        $receive_update->files = $request->input('files');
        if ($sender_update->save() && $receive_update->save()) {
            $updated = Sender::find($request->id);
            return response()->json([
                'message' => 'Your change has been updated',
                'sender_update' => $update
            ]);
            }
        else {
            return response()->json([
                'message' => 'Your change has failed to update. Please contact to your backend to resolve this problem',
            ]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Chat::find($id);
        if ($destroy->delete()) {
            return response()->json([
                'message' => 'Chats succesfully deleted'
            ]);
        }
        else {
            return response()->json([
                'message' => 'Chats failed deleted. Please contact to your backend to resolve this problem'
            ]);
        }
    }


    //chat aplication fixed
    public function getMessage($sender_id,$receiver_id)
    {
    
        $chat = Chat::where(function($q) use ($sender_id,$receiver_id) {
            $q->where('sender_id', $sender_id);
            $q->where('receiver_id', $receiver_id);
        })->orWhere(function($q) use ($sender_id,$receiver_id) {
            $q->where('sender_id', $receiver_id);
            $q->where('receiver_id', $sender_id);
        })->get();

        return response()->json([
            'message' => $chat
        ]);
    }

    public function sendMessage(Request $request)
    {
        
        $chat = new Chat;
        $chat->text = $request->input('text');
        $chat->files = $request->input('files');
        $chat->sender_id = $request->input('sender_id');
        $chat->receiver_id = $request->input('receiver_id');
        if (!$chat->save()) {
            return response()->json(['message' => 'Message cannot sended']);
        }

        // broadcast(new MyEvent($chat));

        return response()->json($chat);
    }
}
