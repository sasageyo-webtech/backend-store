    <?php

    use App\Models\Customer;
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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class); // เชื่อมกับตาราง customers
            $table->foreignIdFor(Product::class); // เชื่อมกับตาราง products
            $table->integer('quantity')->default(1); // จำนวนสินค้าที่เลือก
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
