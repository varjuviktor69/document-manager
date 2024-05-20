<?php

declare(strict_types=1);

use App\Enums\Category as EnumsCategory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const DEFAULT_USERNAME = 'Default User';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = User::whereName(self::DEFAULT_USERNAME)->firstOrFail();
        $user->category_id = Category::whereSlug(EnumsCategory::DEFAULT->value)->firstOrFail()->id;
        $user->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $user = User::whereName(self::DEFAULT_USERNAME)->firstOrFail();
        $user->category_id = null;
        $user->save();
    }
};
