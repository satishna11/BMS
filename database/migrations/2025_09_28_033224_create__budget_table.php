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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id('budget_id');
            $table->year('year');
            $table->string('month');
            $table->decimal('planned_budget', 10, 2);
            $table->decimal('spent_budget', 10, 2);
            $table->decimal('remaining', 10, 2);
            $table->enum('status', ['On Track', 'Overspent']);
            $table->timestamps();

            // foreign key columns
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');

            // foreign key constraints
            $table->foreign('user_id')
                  ->references('id')
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
        Schema::dropIfExists('budgets');
    }
};
