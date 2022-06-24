<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained('product_subcategory');
            $table->string('product_name',250);
            $table->string('slug',250)->nullable();
            $table->string('description',500);
            $table->string('discount',50);
            $table->string('price',50);
            $table->string('quantity',50);
            $table->string('product_excerpt',100);
            $table->string('banner',250);
            $table->boolean('status')->default(1);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->foreignId('category_id')->constrained('product_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
