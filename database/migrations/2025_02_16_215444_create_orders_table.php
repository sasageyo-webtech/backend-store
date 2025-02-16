<?php

use App\Models\Customer;
use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipment;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(Shipment::class);
            $table->foreignIdFor(Payment::class);
            $table->decimal('total_price', 10, 2)->default(0)->comment("ราคารวม");
            $table->string('status')->default(OrderStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
