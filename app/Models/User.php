<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name',];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
}
