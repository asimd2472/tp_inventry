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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100)->nullable();
            $table->string('model', 150)->nullable();
            $table->string('finish', 100)->nullable();
            $table->string('design', 100)->nullable();
            $table->string('shade', 150)->nullable();

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();

            $table->integer('tspl')->default(0);
            $table->integer('all_stock')->default(0);
            $table->integer('ultimate')->default(0);

            $table->timestamps();

            $table->index(['type','model','finish','design','shade'], 'inventory_search_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
