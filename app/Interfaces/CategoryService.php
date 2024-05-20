<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Category;

interface CategoryService
{
    public function findBySlug(string $slug): ?Category;

    public function getCategoryTree(Category $category): void;

    public function delete(int $id): Category;

    public function update(int $id, string $name): bool;

    public function create(int $parentId, string $name): Category;
}