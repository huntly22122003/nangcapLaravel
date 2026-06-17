<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'extraname')) {
                $table->string('extraname')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'technic_info')) {
                $table->longText('technic_info')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'origin')) {
                $table->string('origin')->nullable()->after('brand');
            }
            if (!Schema::hasColumn('products', 'model_no')) {
                $table->string('model_no')->nullable()->after('origin');
            }
            if (!Schema::hasColumn('products', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('model_no');
            }
            if (!Schema::hasColumn('products', 'has_gallery')) {
                $table->boolean('has_gallery')->default(false)->after('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'extraname',
                'technic_info',
                'origin',
                'model_no',
                'sort_order',
                'has_gallery',
            ]);
        });
    }
};