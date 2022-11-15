<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;

class BlogRepository
{
    public function store($blogInput)
    {
        Blog::create($blogInput);
    }
    public function update($blogInput)
    {
        $blog = Blog::find($blogInput["id"]);
        $oldImage = $blog->getImageName();
        $blog->image = $blogInput["image"] ?? $oldImage;
        $blog->title = $blogInput["title"];
        $blog->context = $blogInput["context"];
        $blog->category_id = $blogInput["category_id"];
        $blog->save();
        return ["blog" => $blog, "old_image" => $oldImage];
    }
    public function getCategories()
    {
        return Category::get();
    }
    public function getBlogs($pageSize, $userId, $categoryId)
    {
        return Blog::when($userId, function ($query) use ($userId) {
            $query->where("user_id", $userId);
        })->when($categoryId, function ($query) use ($categoryId) {
            $query->where("category_id", $categoryId);
        })->with("user")->withCount("comments")->latest()->paginate($pageSize);
    }
    public function getRecentBlogs()
    {
        return Blog::take(3)->latest()->get();
    }
    public function show($id)
    {
        return Blog::with(["user"])->withCount("comments")->find($id);
    }
    public function getAllUsers($pageSize, $userId)
    {
        return User::when($userId, function ($query) use ($userId) {
            $query->where("id", "<>", $userId);
        })->paginate($pageSize);
    }
    public function getLatestUsers(){
        return User::take(3)->latest()->get();
    }
}
