<?php

namespace App\Http\Controllers;

use App\Sender;
use Illuminate\Http\Request;
use App\Receiver;
use App\User;
use App\Chat;
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
        $user = User::whereNotIn('id',[$id])->get();
        return response()->json($user);

    }
    
    public function store(Request $request)
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
        $sender = Sender::where('sender_id',$sender_id)
                        ->where('receiver_id',$receiver_id)->get();
        
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
        $destroy = Sender::find($id);
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
}
