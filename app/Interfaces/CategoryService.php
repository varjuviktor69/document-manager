<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Category;
use App\Models\User;

interface CategoryService
{
    public function findBySlug(string $slug): ?Category;

    public function findById(int $id): Category;

    public function getCategoryTree(Category $category): void;

    public function delete(int $id): bool;

    public function update(int $id, string $name): bool;

    public function create(int $parentId, string $name): Category;

    public function getCategoryIdsByUser(User $user): array;
}