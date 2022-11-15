<?php

namespace App\Repositories\Blog;

use App\Models\Comment;

class CommentRepository
{
    public function createComment($commentInput)
    {
        return Comment::create($commentInput);
    }
    public function getComments($pageSize, $blogId)
    {
        return Comment::with("user")->where("blog_id", $blogId)->paginate($pageSize);
    }
    public function deleteComment($id)
    {
        Comment::destroy($id);
    }
}
