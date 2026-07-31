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
        Schema::create('cvr_complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cvr_id')->constrained('cvr_details');
            $table->string('complaint_id')->nullable();
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->string('severity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvr_complaints');
    }
};
