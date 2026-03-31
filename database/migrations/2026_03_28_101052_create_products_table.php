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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Basic Info
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->string('product_image')->nullable();

            // Relations
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('supp_id');

            // Product Details
            $table->string('brand')->nullable();
            $table->string('unit')->default('pcs'); // pcs, kg, box, liter, etc

            // Pricing
            $table->decimal('cost_price', 12, 2)->default(0);   // buying price
            $table->decimal('sell_price', 12, 2)->default(0);   // selling price
            $table->decimal('vat', 5, 2)->default(0);           // VAT percentage (e.g. 15.00)

            // Stock Control
            $table->integer('min_stock')->default(0);  // alert level
            $table->integer('max_stock')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // Extra Useful Fields
            $table->text('description')->nullable();
            $table->string('barcode')->nullable(); // for scanner
            $table->string('location')->nullable(); // shelf / warehouse location
            $table->date('expiry_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
