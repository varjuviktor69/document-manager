<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const DEFAULT_CATEGORY_NAME = 'User Interfaces';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Category::create([
            'name' => self::DEFAULT_CATEGORY_NAME,
            'slug' => slugify(self::DEFAULT_CATEGORY_NAME),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Category::whereName(self::DEFAULT_CATEGORY_NAME)->firstOrFail()->delete();
    }
};
