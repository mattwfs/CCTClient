<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\Application;
use App\User;
use App\Conversation;
use Validator;
use Session;

class MessagesController extends Controller
{
    function index($user_id) {
        $data['user'] = User::find($user_id);
        $conversation = Conversation::where("user_a",$user_id)
                                        ->orWhere("user_b",$user_id)
                                        ->first();
        if($conversation){
            return redirect(url('admin/conversation/'.$conversation->id));
        }
        else{
            return view('admin.message-create',$data);
        }

    }


    function conversations() {
        $data['conversations'] = Conversation::whereNull("deleted_at")->where("user_a",auth()->user()->id)
                                                ->orWhere("user_b",auth()->user()->id)
                                                ->get();
        return view('admin.conversations',$data);
    }


    function conversation($conversation_id) {
        $conversation = Conversation::find($conversation_id);
        $user_id = $conversation->user_a;
        if($conversation->user_a = auth()->user()->id){
          $user_id = $conversation->user_b;
        }
        $data['user'] = User::find($user_id);
        $data['conversation_id'] = $conversation_id;
        $data['messages'] = Message::where("conversation_id",$conversation_id)->get();
        return view('admin.messages',$data);
    }


    function post_message(Request $request) {
        $validator = Validator::make($request->all(),[
            'message' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->application_id){
            $conversation = Conversation::where("user_a",$request->user_id)
                ->where("user_b",$request->user_id)
                ->where("application_id",$request->application_id)
                ->whereNull("deleted_at")
                ->first();
            if(! $conversation){
                $conversation = new Conversation;
                $conversation->user_a = auth()->user()->id;
                $conversation->user_b = $request->user_id;
                $conversation->application_id = $request->application_id;
                $conversation->save();
            }

            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = $request->user_id;
            $message->msg_from = auth()->user()->id;
            $message->message = $request->message;
            $message->save();
            return redirect(url('admin/application/'.$request->application_id));
        } else {
            $conversation = Conversation::where("user_a",$request->user_id)
                ->orWhere("user_b",$request->user_id)
                ->whereNull("deleted_at")
                ->first();
            if(! $conversation){
                $conversation = new Conversation;
                $conversation->user_a = auth()->user()->id;
                $conversation->user_b = $request->user_id;
                $conversation->application_id = $request->application_id;
                $conversation->save();
            }

            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = $request->user_id;
            $message->msg_from = auth()->user()->id;
            $message->message = $request->message;
            $message->save();
            return redirect(url('admin/conversation/'.$conversation->id));
        }


    }

    function send_message(Request $request) {
        $admin_user_id = auth()->user()->id;
        $message_txt = $request->message;
        $conversation = Conversation::find($request->conversation_id);

        $message = new Message;
        $message->user_id = $request->user_id;
        $message->msg_from = auth()->user()->id;
        $message->conversation_id = $conversation->id;
        $message->message = $message_txt;
        $message->save();
        return redirect()->back();
    }



    function group_message_page($trial_id){
        $data['applications'] = Application::where("trial_id",$trial_id)
                                            ->distinct('user_id')
                                            ->get();

        return view('admin.group-message',$data);

    }


    function group_message_post(Request $request) {

        $sent = '';

        if(! count($request->users)){
            Session::flash('error','You need to check at least one user.');
            return redirect()->back()->withInput();
        }

        foreach($request->users as $user_id){
            $conversation = Conversation::where("user_a",$user_id)
                                        ->orWhere("user_b",$user_id)
                                        ->first();
        if(! $conversation){
            $conversation = new Conversation;
            $conversation->user_a = auth()->user()->id;
            $conversation->user_b = $request->user_id;
            $conversation->save();
        }

        $message = new Message;
        $message->conversation_id = $conversation->id;
        $message->user_id = $user_id;
        $message->msg_from = auth()->user()->id;
        $message->message = $request->message;
        $message->save();
        $sent .= get_user_name($user_id).',';
        }

        Session::flash('message','Message sent to: '. rtrim($sent,','));
        return redirect()->back();
    }
}
