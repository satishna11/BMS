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


    Schema::create('expenses', function (Blueprint $table) {
    $table->bigIncrements('expense_id');
    $table->decimal('amount', 10, 2);
    $table->date('date');
    $table->text('description')->nullable();
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('category_id');
    $table->timestamps();

    $table->foreign('user_id')
          ->references('id') // matches users table
          ->on('users')
          ->onDelete('cascade');

    $table->foreign('category_id')
          ->references('category_id')
          ->on('categories')
          ->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense');
    }
};
