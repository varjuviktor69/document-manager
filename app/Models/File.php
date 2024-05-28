<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use stdClass;

class File extends Model
{
    protected $guarded = [];

    public $appends = [
        'next_version_suffix',
        'visible_name',
        'path',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getNextVersionSuffixAttribute(): string
    {
        return  '-v' . (string) ($this->version + 1);
    }

    public function getVisibleNameAttribute(): string
    {
        return $this->name . '.' . $this->extension;
    }

    public function categories(): array
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
            'id' => $this->category_id,
        ]);

        return $results;
    }

    public function getPathAttribute(): string
    {
        $category = $this->category;

        $categorySlugs = array_map(function(stdClass $category): string {
            return $category->slug;
        }, $category->ancestor_categories);

        $categorySlugs[] = $category->slug;
        
        return implode(DIRECTORY_SEPARATOR, $categorySlugs);
    }
}
