<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'employee'])->default('employee')->after('email');
            });
        }
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('role');
            });
        }
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('phone');
            });
        }
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'is_active']);
        });
    }
};