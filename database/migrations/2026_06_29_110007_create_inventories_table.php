<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->integer('theoretical_quantity');
            $table->integer('physical_quantity');
            $table->integer('difference');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('inventories');
    }
};