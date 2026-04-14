<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add parent_id to products so a product can have variants
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')
                ->constrained('products')->nullOnDelete();
            $table->string('product_number')->unique()->nullable()->after('sku'); // Shopware-style product number
            $table->string('ean')->nullable()->after('product_number');
        });

        // Variant ↔ property_option mapping (which options define this variant)
        Schema::create('product_variant_options', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_option_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'property_option_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variant_options');
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'product_number', 'ean']);
        });
    }
};
