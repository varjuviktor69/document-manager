<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Interfaces\CategoryService;
use App\Interfaces\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private CategoryService $categoryService,
        private FileService $fileService
    ) {}

    public function index(): View
    {
        $defaultCategory = $this->categoryService->findById(Auth::user()->category_id);
        $files = $this->fileService->getByCategoryId($defaultCategory->id);

        return view('index', [
            'defaultCategory' => $this->categoryService->findBySlug(Category::DEFAULT->value),
            'files' => $files,
        ]);
    }
}
