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
            $table->string('dimention', 100)->nullable()->after('height');
            $table->string('colour', 100)->nullable()->after('dimention');
            $table->string('orientation', 100)->nullable()->after('colour');
            $table->string('special_feature', 100)->nullable()->after('orientation');
            $table->integer('hyderabad')->default(0)->after('special_feature');
            $table->integer('ncr')->default(0)->after('hyderabad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            //
        });
    }
};
