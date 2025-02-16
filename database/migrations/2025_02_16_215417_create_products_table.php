<?php

use App\Models\Category;
use App\Models\Enums\ProductAccessibility;
use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class);
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->jsonb('image_paths')->nullable()->comment("list of image path");
            $table->decimal('rating', 2, 1)->default(0)->comment("0 - 5");
            $table->integer('likes')->default(0);
            $table->string('accessibility')->default(ProductAccessibility::PUBLIC)->comment("product accessibility PUBLIC or PRIVATE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
