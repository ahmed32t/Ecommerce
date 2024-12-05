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
        Schema::create('subcategories_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('parrentcategories')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('subcategories_products')->onDelete('cascade');
            $table->double('price',8,3)->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('special_name')->unique();
            $table->string('details')->nullable();
            $table->double('sale',8,3)->nullable();
            $table->string('photo');
            $table->string('small_descripe')->nullable();
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories_products');
    }
};
