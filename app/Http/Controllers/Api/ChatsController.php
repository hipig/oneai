<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Models\Message;
use App\Settings\ChatSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatsController extends Controller
{
    public function index(Request $request)
    {
        $chats = Chat::query()->where('user_id', Auth::id())->latest()->get();

        return ChatResource::collection($chats);
    }

    public function store(Request $request, ChatSetting $setting)
    {
        $name = Str::substr($request->name, 0, 15) ?? '新的会话';
        $chat = new Chat([
            'name' => $name,
            'config' => [
                'model' => $setting->model,
                'temperature' => 0.8,
                'top_p' => 1,
                'max_tokens' => 2000,
                'presence_penalty' => 0,
                'frequency_penalty' => 0
            ]
        ]);
        $chat->user()->associate(Auth::user());
        $chat->save();

        return ChatResource::make($chat);
    }

    public function update(Request $request, Chat $chat)
    {
        $this->authorize('own', $chat);

        $chat->fill(
            $request->only([
                'name', 'config'
            ])
        );
        $chat->save();

        return ChatResource::make($chat);
    }

    public function destroy(Chat $chat)
    {
        $this->authorize('own', $chat);

        $chat->delete();
        $chat->messages()->delete();

        return response()->noContent();
    }

    public function stream(Chat $chat)
    {
        $this->authorize('own', $chat);

        $firstMessage = Message::query()->where('chat_id', $chat->id)->where('type', Message::TYPE_NEW_CONTEXT)->latest()->first();
        if (!$firstMessage) {
            $firstMessage = Message::query()->where('chat_id', $chat->id)->latest()->first();
        }

        $messages = Message::query()->where('chat_id', $chat->id)->where('id', '>=', $firstMessage->id)->whereIn('type', [Message::TYPE_USER, Message::TYPE_ASSISTANT])->latest()->limit(10)->get();
        $messages = $messages->map(function ($message) {
            return [
                'role' => $message->type,
                'content' => $message->content
            ];
        })->reverse();

        $config = $chat->config;
        $config['messages'] = $messages;
        $stream = app('openai')->chat()->createStreamed($config);

        return response()->stream(function () use ($stream) {
            foreach($stream as $response){
                echo "event: message\n";
                echo "data:" . json_encode($response->choices[0], JSON_UNESCAPED_UNICODE) . "\n\n";
                ob_flush();
                flush();
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}
