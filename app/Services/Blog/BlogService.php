<?php

namespace App\Services\Blog;

use App\Repositories\Blog\BlogRepository;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function store($blogInput, $user, $image)
    {
        $blogInput["image"] = $image->store("");
        $blogInput["user_id"] = $user->id;
        $this->blogRepository->store($blogInput);
    }
    public function update($blogInput, $image)
    {
        if ($image) {
            $blogInput["image"] = $image->store("");
        }
        $result = $this->blogRepository->update($blogInput);
        if ($image) {
            Storage::delete($result["old_image"]);
        }
        return $result["blog"];
    }
    public function getCategories()
    {
        return $this->blogRepository->getCategories();
    }
    public function getBlogs($pageSize, $userId, $categoryId)
    {
        return $this->blogRepository->getBlogs($pageSize, $userId, $categoryId);
    }
    public function getRecentBlogs()
    {
        return $this->blogRepository->getRecentBlogs();
    }
    public function show($id){
        return $this->blogRepository->show($id);
    }
    public function getAllUsers($pageSize,$userId)
    {
        return $this->blogRepository->getAllUsers($pageSize,$userId);
    }
    public function getLatestUsers(){
        return $this->blogRepository->getLatestUsers();
    }
}
