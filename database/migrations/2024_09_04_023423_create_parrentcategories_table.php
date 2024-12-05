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
        Schema::create('parrentcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');



            $table->string('name');

            $table->string('slug');

            $table->string('special_name')->unique();
            $table->double('sale',8,3)->nullable();
            // column sale use as information to make sale in all products that belong to these category
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
        Schema::dropIfExists('parrentcategories');
    }
};
