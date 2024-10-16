<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentCreateRequest;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function store(CommentCreateRequest $request): JsonResponse
    {
        $commentableType = $request->input('commentable_type');
        $commentable = $commentableType === 'App\\Models\\Product'
            ? Product::findOrFail($request->input('commentable_id'))
            : Service::findOrFail($request->input('commentable_id'));

        $comment = $commentable->comments()->create([
            'body' => $request->get('body'),
            'user_id' => auth()->id(),
        ]);

        return response()->json(['comment' => $comment, 'product_or_service' => $commentable]);
    }
}
