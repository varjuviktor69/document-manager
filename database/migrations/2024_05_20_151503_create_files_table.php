<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Category::class)->cascadeOnDelete();
            $table->smallInteger('version');
            $table->string('slug');
            $table->string('name');
            $table->string('extension');

            $table->unique(['slug', 'category_id', 'extension']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
