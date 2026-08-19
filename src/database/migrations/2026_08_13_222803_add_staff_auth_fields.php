<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->index();
            }

            if (! Schema::hasColumn('users', 'active')) {
                $table->boolean('active')->default(true)->index();
            }
        });

        if (! Schema::hasTable('staff_access_tokens')) {
            Schema::create('staff_access_tokens', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('user_id')->index();
                $table->string('name');
                $table->string('token_hash', 64)->unique();
                $table->timestamp('last_used_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_access_tokens');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'active')) {
                $table->dropColumn('active');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
