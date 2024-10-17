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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->string('SID')->unique();
            $table->integer('next_reply_id')->nullable()->default(null);
            $table->integer('user_id');
            $table->string('sender')->nullable();
            $table->string('attached_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
