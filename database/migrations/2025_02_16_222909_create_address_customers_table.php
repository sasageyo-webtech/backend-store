<?php

use App\Models\Customer;
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
        Schema::create('address_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('name')->comment('receiver name');
            $table->string('phone_number')->comment('receiver phone number');
            $table->string('house_number')->comment('บ้านเลขที่');
            $table->string('building')->nullable()->comment('ห้อง อาคาร ชั้น');
            $table->string('street')->comment('ถนน');
            $table->string('sub_district')->comment("แขวง");
            $table->string('district')->comment('เขต');
            $table->string('province')->comment('จังหวัด');
            $table->string('postal_code')->comment('รหัสไปรษณีย์');
            $table->string('country')->default('Thailand')->comment('ประเทศ');
            $table->string('detail_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_customers');
    }
};
