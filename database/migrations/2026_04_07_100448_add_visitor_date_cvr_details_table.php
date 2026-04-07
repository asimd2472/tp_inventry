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
        Schema::table('cvr_details', function (Blueprint $table) {
            $table->date('visitor_date')->nullable()->after('cvr_data');
            $table->time('visitor_time')->nullable()->after('visitor_date');
            $table->string('visitor_name')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cvr_details', function (Blueprint $table) {
            //
        });
    }
};
