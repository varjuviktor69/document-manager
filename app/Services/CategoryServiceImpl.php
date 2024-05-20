<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CategoryService;
use App\Models\Category;

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

    public function delete(int $id): Category
    {
        return Category::findOrFail($id)->delete();
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