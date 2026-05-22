<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin', 'super_admin'])->default('user')->after('email_verified_at');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->integer('api_quota')->default(10000)->after('status');
            $table->integer('api_calls_this_month')->default(0)->after('api_quota');
            $table->timestamp('last_login_at')->nullable()->after('api_calls_this_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'api_quota', 'api_calls_this_month', 'last_login_at']);
        });
    }
};
