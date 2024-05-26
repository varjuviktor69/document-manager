<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CategoryService;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CategoryServiceImpl implements CategoryService
{

    public function findBySlug(string $slug): ?Category
    {
        return Category::whereSlug($slug)->first();
    }

    public function getCategoryTree(Category $category): void
    {   
        $category->category_tree = $category->sub_categories;
        $this->sort_r($category);
    }

    public function delete(int $id): bool
    {
        $category = Category::findOrFail($id);
        $directory = $category->directory_path;
        Storage::deleteDirectory($directory);

        return $category->delete();
    }

    public function update(int $id, string $name): bool
    {
        return Category::findOrFail($id)->update([
            'name' => $name,
            'slug' => slugify($name),
        ]);
    }

    public function create(int $parentId, string $name): Category
    {
        return Category::create([
            'name' => $name,
            'slug' => slugify($name),
            'parent_id' => $parentId,
        ]);
    }

    public function findById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function getCategoryIdsByUser(User $user): array
    {
        $categories = $user->categories();
        $categoryIds = array_map(function(stdClass $category): int {
            return $category->id;
        }, $categories);
        $categoryIds[] = $user->category_id;

        return $categoryIds;
    }

    private function sort_r(Category $category): void
    {
        foreach ($category->category_tree as $subCategory) {
            $subCategory->children = [];

            if ($subCategory->parent_id === $category->id) {
                $subCategory->children[] = $this->sort_r($category);
            }
        }
    }
}