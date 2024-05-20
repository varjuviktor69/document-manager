<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Interfaces\CategoryService;
use Carbon\CarbonImmutable;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index(): View
    {
        return view('index', [
            'defaultCategory' => $this->categoryService->findBySlug(Category::DEFAULT->value),
        ]);
    }
}
