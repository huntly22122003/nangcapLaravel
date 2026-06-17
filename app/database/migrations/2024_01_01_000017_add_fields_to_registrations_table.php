<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
            $table->string('session_id')->nullable()->after('username');
            $table->boolean('status')->default(false)->after('session_id');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['username', 'session_id', 'status']);
        });
    }
};