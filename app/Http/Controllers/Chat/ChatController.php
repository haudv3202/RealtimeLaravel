<?php

namespace App\Http\Controllers\Chat;

use App\Events\GettingSent;
use App\Events\SentMessege;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('chat.show');
    }

    public function messageSent(Request $request) {
        $rules = [
            'message' => 'required'
        ];
        $request->validate($rules);
        broadcast(new SentMessege($request->user(),$request->message));

        return response()->json('Message success');
    }

    public function greetRecevied(Request $request,User $user){
        broadcast(new GettingSent($user,"{$request->user()->name} greeted you"));
        broadcast(new GettingSent($request->user(),"You greeted {$user->name}"));
        return "gertting {$user->name} from {$request->user()->name}";
    }
}
