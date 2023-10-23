<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromptGroupResource;
use App\Models\Prompt;
use App\Models\PromptGroup;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PromptGroupsController extends Controller
{
    public function index(Request $request)
    {
        $groups = PromptGroup::query()->with(['prompts' => function(Builder $p) {
            $p->where('status', Prompt::STATUS_ENABLE)->latest();
        }])->where('status', PromptGroup::STATUS_ENABLE)->get();

        return PromptGroupResource::collection($groups);
    }
}
