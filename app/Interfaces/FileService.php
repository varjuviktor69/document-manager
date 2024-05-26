<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

interface FileService
{
    public function save(UploadedFile $file, int $categoryId): string|false;

    public function findBySlugAndExtension(string $slug, string $extension): ?File;

    public function getByCategoryId(int $categoryId): Collection;

    public function findById(int $id): File;

    public function getNameWithVersion(int $version, File $file): string;

    public function getAllByUser(User $user): Collection;
}