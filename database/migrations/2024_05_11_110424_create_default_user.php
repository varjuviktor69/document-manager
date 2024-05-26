<?php

declare(strict_types=1);

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
        User::create([
            'name' => self::DEFAULT_USERNAME,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::whereName(self::DEFAULT_USERNAME)->firstOrFail()->delete();
    }
};
