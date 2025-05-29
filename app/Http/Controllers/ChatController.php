<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Http\Controllers\Controller;
use App\Models\chats;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Ambil semua pesan antara 2 user (biar bisa tampilkan chat personal)
        $userId = request('user_id');
        return chats::where(function ($q) use ($userId) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })
            ->orderBy('created_at')
            ->get();
    }

    public function store(Request $request)
    {
        $message = chats::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new ChatSent($message))->toOthers();

        return response()->json(['status' => 'sent']);
    }
    public function viewChat(User $user)
    {
        // Hindari menampilkan diri sendiri
        if ($user->id === auth()->id()) {
            return redirect('/')->with('error', 'Tidak bisa chat dengan diri sendiri.');
        }
        $users = User::where('id', '!=', auth()->id())->get();


        return view('chats', [
            'receiver' => $user,
            'users' => $users,
        ]);
    }
}
