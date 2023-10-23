<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromptResource;
use App\Models\Message;
use App\Models\Prompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PromptsController extends Controller
{
    public function random(Request $request)
    {
        $size = $request->size ?? 6;
        $prompts = Prompt::query()->where('status', Prompt::STATUS_ENABLE)->inRandomOrder()->take($size)->get();

        return PromptResource::collection($prompts);
    }
}
