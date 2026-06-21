<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('extraname')->nullable();
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('brand')->nullable();
            $table->string('origin')->nullable();
            $table->string('model_no')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('technic_info')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('has_gallery')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};