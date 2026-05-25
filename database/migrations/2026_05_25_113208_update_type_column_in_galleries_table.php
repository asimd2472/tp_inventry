<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE galleries 
                MODIFY COLUMN type 
                ENUM('dealers', 'brochure', 'installation_images') 
                DEFAULT 'brochure'
            ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE galleries 
                MODIFY COLUMN type 
                ENUM('dealers', 'brochure') 
                DEFAULT 'brochure'
            ");
        });
    }
};
