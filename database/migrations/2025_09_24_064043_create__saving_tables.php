<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saving', function (Blueprint $table) {
            $table->id('saving_id');
            $table->string('goal');
            $table->decimal('target_amount',10,2);
            $table->decimal('amount',10,2);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->delete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('saving');
    }
};
