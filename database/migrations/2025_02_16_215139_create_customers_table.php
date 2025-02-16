<?php

use App\Models\User;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('gender');
            $table->string('birthdate');
            $table->string('citizen_code');
            $table->jsonb('cart')->nullable()->comment("list product in cart");
            $table->jsonb('product_likes')->nullable()->comment('list of wishlist');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
