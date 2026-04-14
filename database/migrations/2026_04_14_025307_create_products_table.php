<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('image')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_property_option', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_option_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'property_option_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_property_option');
        Schema::dropIfExists('products');
    }
};
