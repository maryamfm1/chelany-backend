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
    Schema::create('menu_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('category_id');
        $table->string('name_en');
        $table->string('name_de');
        $table->text('description_en')->nullable();
        $table->text('description_de')->nullable();
        $table->string('price')->nullable();
        $table->timestamps();

        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
