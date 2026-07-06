<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('Mon Entreprise');
            $table->string('slogan')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('rccm')->nullable();
            $table->string('ifu')->nullable();
            $table->string('logo')->nullable();
            $table->string('stamp')->nullable();
            $table->string('currency')->default('FCFA');
            $table->text('invoice_footer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('company_settings');
    }
};