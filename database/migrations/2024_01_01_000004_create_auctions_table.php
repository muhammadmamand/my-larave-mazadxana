<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image')->nullable();
            $table->decimal('starting_price', 12, 2);
            $table->decimal('current_price', 12, 2);
            $table->decimal('reserve_price', 12, 2)->nullable();
            $table->decimal('bid_increment', 12, 2)->default(10);
            $table->unsignedInteger('bid_count')->default(0);
            $table->unsignedInteger('watchers')->default(0);
            $table->enum('status', ['upcoming', 'live', 'ended', 'sold'])->default('live');
            $table->boolean('featured')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
