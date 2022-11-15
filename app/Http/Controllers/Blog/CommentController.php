<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Services\Blog\CommentService;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware("auth")->except("getComments");
    }
    public function createComment(CreateCommentRequest $request)
    {
        $request->merge(["user_id" => $request->user()->id]);
        return $this->commentService->createComment($request->input());
    }
    public function getComments($blogId)
    {
        return $this->commentService->getComments(request()->page_size, $blogId);
    }
    public function deleteComment($id){
         $this->commentService->deleteComment($id);
    }
}
