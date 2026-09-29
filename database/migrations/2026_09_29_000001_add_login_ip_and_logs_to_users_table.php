<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip', 45)->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('last_login_ip');
            }
        });

        if (!Schema::hasTable('user_login_logs')) {
            Schema::create('user_login_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('email');
                $table->string('ip_address', 45);
                $table->string('status'); // 'Success' or 'Failed'
                $table->text('user_agent')->nullable();
                $table->timestamp('login_at');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_login_logs');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_login_ip', 'last_login_at']);
        });
    }
};
