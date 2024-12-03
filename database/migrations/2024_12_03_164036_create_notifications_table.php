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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('type');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('scheduled_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
