<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Services\Blog\BlogService;

class BlogController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->middleware('auth')->only(["store", "update"]);
        $this->blogService = $blogService;
    }

    public function store(StoreBlogRequest $request)
    {
        $this->blogService->store($request->validated(), $request->user(), $request->file("image"));
    }

    public function show($id)
    {
        return $this->blogService->show($id);
    }

    public function update(UpdateBlogRequest $request)
    {
        return $this->blogService->update($request->validated(), $request->file("image"));
    }

    public function getCategories()
    {
        return $this->blogService->getCategories();
    }

    public function getBlogs()
    {
        return $this->blogService->getBlogs(
            request()->page_size,
            request()->user_id,
            request()->category_id,
        );
    }

    public function getRecentBlogs()
    {
        return $this->blogService->getRecentBlogs();
    }
    public function getAllUsers()
    {
        $user = request()->user();
        return $this->blogService->getAllUsers(request()->page_size, $user ? $user->id : null);
    }
    public function getLatestUsers()
    {
        return $this->blogService->getLatestUsers();
    }
}
