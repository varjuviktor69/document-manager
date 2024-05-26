<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Category as EnumsCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $guarded = [];

    public $appends = ['sub_categories',];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getSubCategoriesAttribute(): array
    {
        $results = DB::select('WITH RECURSIVE categories_cte(id, name, slug, parent_id) AS (
            SELECT id, name, slug, parent_id FROM categories
            WHERE id = :id
            UNION
            SELECT ct.id, ct.name, ct.slug, ct.parent_id FROM categories ct
            JOIN categories_cte cc ON cc.id = ct.parent_id
        )
        SELECT * FROM categories_cte
        WHERE categories_cte.id != :id', [
            'id' => $this->id
        ]);

        $results = array_map(function ($v): Category {
            return new Category([
                'id' => $v->id,
                'name' => $v->name,
                'parent_id' => $v->parent_id,
                'slug' => $v->slug,
            ]);
        }, $results);

        $results = self::buildTree($results, $this->id);

        return $results;
    }

    private function buildTree(array $subCategories, int $parentId ): array
    {
        $branch = [];
    
        foreach ($subCategories as $subCategory) {
            if ($subCategory->parent_id === $parentId) {
                $children = self::buildTree($subCategories, $subCategory->id);

                if ($children) {
                    $subCategory->sub_categories = $children;
                }

                $branch[] = $subCategory;
            }
        }
    
        return $branch;
    }
}
