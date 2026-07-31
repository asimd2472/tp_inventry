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
        Schema::create('cvr_action_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cvr_id')->constrained('cvr_details');
            $table->string('action_id')->nullable();
            $table->longText('task')->nullable();
            $table->string('owner')->nullable();
            $table->date('deadline')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvr_action_points');
    }
};
