<?php

namespace App\Services\Blog;

use App\Repositories\Blog\CommentRepository;

class CommentService
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment($commentInput)
    {
        return  $this->commentRepository->createComment($commentInput);
    }

    public function getComments($pageSize,$blogId)
    {
        return $this->commentRepository->getComments($pageSize,$blogId);
    }
    public function deleteComment($id){
        $this->commentRepository->deleteComment($id);
    }
}
