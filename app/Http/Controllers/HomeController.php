<?php

namespace App\Http\Controllers;

use App\Events\Message as EventsMessage;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Message;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Select All User Except User Logged in
        //$users = User::where('id', '!=', Auth::id())->get();

        //Count How Many Message Are Unread From The Selected User
        $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread 
        from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        where users.id != " . Auth::id() . " 
        group by users.id, users.name, users.avatar, users.email");
        return view('home', ['users' => $users]);
    }

    public function getMessage($id){
        $my_id = Auth::id();
        $messages = Message::where(function($query) use ($id, $my_id){
            $query->where('from', $my_id)->where('to', $id);
        })->orWhere(function($query) use ($id, $my_id){
            $query->where('from', $id)->where('to', $my_id);
        })->get();

        return view('messages.index', ['messages' => $messages]);
    }

    public function sendMessage(Request $request){
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $data = ['from' => $from, 'to' => $to];

        event(new EventsMessage($data));

    }
}
