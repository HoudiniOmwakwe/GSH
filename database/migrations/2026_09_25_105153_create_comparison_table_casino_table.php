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
        Schema::create('comparison_table_casino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comparison_table_id')->constrained()->cascadeOnDelete();
            $table->foreignId('casino_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('ordering')->default(0);
            $table->timestamps();

            $table->unique(['comparison_table_id', 'casino_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparison_table_casino');
    }
};
