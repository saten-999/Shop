<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSentEvent;
class MessageController extends Controller
{
    
    public function index()
    {
        return view('chat');
    }
    
    public function adminchat()
    {
        return view('admin.chat');
    }


    public function onlineadmin()
    {
      $onlineadmin =  User::where('usertype', 'admin')->get();

      return response()->json($onlineadmin);
    }


    public function get()
    {
        $contacts = User::where('id', '!=', auth()->id())->get();

        
    
        $unreadIds = Message::select('from as sender_id', DB::raw("count('from') as messages_count"))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();
        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });


        return response()->json($contacts);
    }


    public function getmessagesfor($id){
        $message =Message::where(function($q) use($id){
            $q->where('from', auth()->id());
            $q->where('to', $id);

        })->orWhere(function($q) use ($id){
            $q->where('from', $id);
            $q->where('to', auth()->id());

        })->get();
        
        return response()->json($message);
    }

    public function send(Request $request){
        
        $message = Message::create([
                        'from' =>auth()->id(),
                        'to'=> $request->contact_id,
                        'text'=> $request->text
                    ]);
        broadcast(new MessageSentEvent($message))->toOthers();
        
        return response()->json($message);
    }

    public function updatemessage($id){
        
        $message = User::find($id)->message()->where('to',auth()->id())->update([
            'read' => true
        ]);
       
        
        return $message;
    }



    
}
