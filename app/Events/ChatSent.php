<?php

namespace App\Events;

use App\Models\Chats; // Pastikan model Chats dengan huruf kapital (sesuai konvensi)
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct(Chats $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        \Log::info("Broadcast to chat.{$this->chat->receiver_id}");
        return new PrivateChannel('chat.' . $this->chat->receiver_id);
    }

    public function broadcastWith()
    {
        \Log::info("Data dikirim: " . json_encode([
            'message' => $this->chat->message,
            'sender_id' => $this->chat->sender_id,
        ]));
        return [
            'message' => $this->chat->message,
            'sender' => $this->chat->sender->name ?? 'Unknown',
            'sender_id' => $this->chat->sender_id,
            'created_at' => $this->chat->created_at->toDateTimeString(),
        ];
    }

}
