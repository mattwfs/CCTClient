<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Message;
use App\Conversation;
use App\User;

class MessagesController extends Controller
{
    function index() {

        $data['conversations'] = Conversation::whereNull("deleted_at")->where("user_a",auth()->user()->id)
            ->orWhere("user_b",auth()->user()->id)
            ->get();
        return view('users.messages',$data);
        /*
        $user_id = auth()->user()->id;
        $conversation_id = 0;
        $conversation = Conversation::where("user_a",$user_id)
                                    ->orWhere("user_b",$user_id)
                                    ->whereNull("deleted_at")
                                    ->first();
        if($conversation){
            $conversation_id = $conversation->id;
        }
            $messages = Message::where("conversation_id",$conversation_id)
                            ->orderBy("id","asc")
                            ->get();
        
        $data['messages'] = $messages;

        return view('users.messages',$data);

        */
    }

    function conversations() {

    }
    
    function single($id) {
        $data['message'] = Message::find($id);
        if($data['message']->user_id != auth()->user()->id){
           return redirect(url('not-authorized'));
        }
        $data['message']->status = 'old';
        $data['message']->save();
        return view('users.message-single',$data);
    }
    
    
    function send_message(Request $request) {
        $admin_user = User::where('role_id',get_role_id('admin'))
                                ->orderBy('id')
                                ->first();
        $admin_user_id = $admin_user->id;
        $message_txt = $request->message;
        $conversation = Conversation::where("user_a",auth()->user()->id)
                                        ->orWhere("user_b",auth()->user()->id)
                                        ->first();
        if(! $conversation){
            $conversation = new Conversation;
            $conversation->user_a = auth()->user()->id;
            $conversation->user_b = $admin_user_id;
            $conversation->save();
        }
        
        $message = new Message;
        $message->user_id = $admin_user_id;
        $message->msg_from = auth()->user()->id;
        $message->conversation_id = $conversation->id;
        $message->message = $message_txt;
        $message->save();
        return redirect()->back();
        
        
    }
    
    
    function send_file(Request $request) {
        if($request->hasFile('attachment')):
                $file = $request->file('attachment');
                $filename = time();
                $original_name = $file->getClientOriginalName();
                $org_name_arr = explode('.',$original_name);
                $extension = $org_name_arr[count($org_name_arr)-1];
                $path = base_path('uploads/downloadables/');
                $file_name = $filename.'.'.$extension;
                $file->move($path, $file_name);
                $response ='<a target="_blank" href="'.url('uploads/downloadables/'.$file_name).'"><i class="fa fa-download"></i>&nbsp;&nbsp;'.$original_name.'</a>';
        echo $response;
        endif;
        
        echo '';
        
    }
    
    

}


