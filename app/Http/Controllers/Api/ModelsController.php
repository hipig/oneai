<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatModelResource;
use App\Models\ChatModel;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function index()
    {
        $models = ChatModel::query()->where('status', ChatModel::STATUS_ENABLE)->get();

        return ChatModelResource::collection($models);
    }
}
