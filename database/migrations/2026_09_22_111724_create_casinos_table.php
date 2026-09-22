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
        Schema::create('casinos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('casino'); // casino, sportsbook, crypto-exchange
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('license_info')->nullable();
            $table->unsignedSmallInteger('established_year')->nullable();
            $table->string('website_url')->nullable();
            $table->string('affiliate_link')->nullable();
            $table->text('bonus_summary')->nullable();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->string('status')->default('draft'); // draft, published, archived
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('ordering')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casinos');
    }
};
