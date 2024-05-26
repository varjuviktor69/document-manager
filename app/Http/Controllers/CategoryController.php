<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Interfaces\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService,
        private Request $request
    ) {}

    public function all(): View
    {
        return view('categories.index', [
            'defaultCategory' => $this->categoryService->findBySlug(Category::DEFAULT->value),
        ]);
    }

    public function edit(int $id): View
    {
        $this->categoryService->update(
            $id,
            $this->request->categoryName
        );
   
        return view('categories.index', [
            'defaultCategory' => $this->categoryService->findBySlug(Category::DEFAULT->value),
        ]);
    }

    public function create(int $parentId): View
    {
        $this->categoryService->create(
            $parentId,
            $this->request->categoryName
        );

        return view('categories.index', [
            'defaultCategory' => $this->categoryService->findBySlug(Category::DEFAULT->value),
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        return response()->json($this->categoryService->delete($id));
    }
}
