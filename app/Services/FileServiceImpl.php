<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CategoryService;
use App\Interfaces\FileService;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class FileServiceImpl implements FileService
{
    public function __construct(private CategoryService $categoryService) {}

    public function save(UploadedFile $file, int $categoryId): string|false
    {
        $fileName = $file->getClientOriginalName();
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $slug = slugify(pathinfo($fileName, PATHINFO_FILENAME));
        $extensionsSlug = slugify($file->getClientOriginalExtension());
        $fileModel = $this->findBySlugAndExtensionAndCategoryId($slug, $extensionsSlug, $categoryId);

        if ($fileModel) {
            $versionSuffix = $fileModel->next_version_suffix;
            $fileModel->version += 1;
            $fileModel->save();
        } else {
            $versionSuffix = getDefaultVersionSuffix();

            $fileModel = File::create([
                'name' => $baseName,
                'slug' => $slug,
                'version' => 1,
                'category_id' => $categoryId,
                'extension' => $extensionsSlug,
            ]);
        }

        $name = $slug . $versionSuffix . '.' . $extensionsSlug;

        return $file->storeAs($fileModel->path, $name);
    }

    public function findBySlugAndExtensionAndCategoryId(string $slug, string $extension, int $categoryId): ?File
    {
        return File::where([
            'slug' => $slug,
            'extension' => $extension,
            'category_id' => $categoryId,
        ])->first();
    }

    public function getByCategoryId(int $categoryId): Collection
    {
        return File::whereCategoryId($categoryId)->get();
    }

    public function findById(int $id): File
    {
        return File::findOrFail($id);
    }

    public function getNameWithVersion(int $version, File $file): string
    {
        return $file->slug . '-v' . $version . '.' . $file->extension;
    }

    public function getAllByUser(User $user): Collection
    {
        $categoryIds = $this->categoryService->getCategoryIdsByUser($user);

        return File::whereIn('category_id', $categoryIds)->get();
    }
}
