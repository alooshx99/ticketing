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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('SID')->unique();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->text('attached_files')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->enum('category', ['general', 'billing', 'technical', 'other'])->default('general');
            $table->integer('receiver_id')->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
