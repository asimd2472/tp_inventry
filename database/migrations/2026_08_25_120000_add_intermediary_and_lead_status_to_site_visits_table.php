<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_visits', function (Blueprint $table) {
            $table->string('intermediary_name', 150)->nullable()->after('competitor');
            $table->string('intermediary_type', 100)->nullable()->after('intermediary_name');
            $table->json('lead_status')->nullable()->after('intermediary_type');
            $table->json('drop_reasons')->nullable()->after('lead_status');
            $table->string('drop_reason_other', 255)->nullable()->after('drop_reasons');
        });
    }

    public function down(): void
    {
        Schema::table('site_visits', function (Blueprint $table) {
            $table->dropColumn([
                'intermediary_name',
                'intermediary_type',
                'lead_status',
                'drop_reasons',
                'drop_reason_other',
            ]);
        });
    }
};
