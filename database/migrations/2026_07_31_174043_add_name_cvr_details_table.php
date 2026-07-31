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
            $table->string('host')->nullable()->after('visitor_name');
            $table->string('distributor')->nullable()->after('host');
            $table->string('visitor')->nullable()->after('distributor');
            $table->string('contact_no')->nullable()->after('visitor');
            $table->string('visit_date')->nullable()->after('contact_no');
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
