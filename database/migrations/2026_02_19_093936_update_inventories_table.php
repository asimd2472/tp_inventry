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
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('user_type', 150)->nullable()->after('id');
            $table->longText('Description')->nullable()->after('model');

            $table->dropColumn('tspl');
            $table->dropColumn('all_stock');
            $table->dropColumn('ultimate');

            $table->integer('d_alhada')->default(0)->after('height');
            $table->integer('d_tspl')->default(0)->after('d_alhada');
            $table->integer('d_ultimate')->default(0)->after('d_tspl');
            $table->integer('d_gmp')->default(0)->after('d_ultimate');

            $table->integer('h_alhada')->default(0)->after('d_gmp');
            $table->integer('h_tspl')->default(0)->after('h_alhada');
            $table->integer('h_ultimate')->default(0)->after('h_tspl');
            $table->integer('h_gmp')->default(0)->after('h_ultimate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            
        });
    }
};
