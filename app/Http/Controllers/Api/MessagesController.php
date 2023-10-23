<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::query()->where('chat_id', $request->chat_id)->latest()->get();

        return MessageResource::collection($messages);
    }

    public function store(Request $request)
    {
        $chat = Chat::query()->where('id', $request->chat_id)->firstOrFail();

        $message = new Message(
            $request->only([
                'type', 'content'
            ])
        );
        $message->chat()->associate($chat);
        $message->save();

        return MessageResource::make($message);
    }
}
