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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();// 1. Sales executive
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('executive_name')->nullable();
            $table->string('executive_email')->nullable();
            $table->date('visit_date');
            $table->time('visit_time');

            // 2. Customer
            $table->string('customer_name', 150);
            $table->string('mobile', 10);
            $table->string('alt_mobile', 10)->nullable();
            $table->string('customer_email')->nullable();

            // 3. Site location
            $table->string('state');
            $table->string('district');
            $table->string('pincode', 6)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('maps_link')->nullable();

            // 4. Construction
            $table->string('construction_stage');

            // 5. Product requirement (JSON arrays)
            $table->json('products');
            $table->json('categories')->nullable();

            // 6. Quantity
            $table->unsignedInteger('qty_doors')->default(0);
            $table->unsignedInteger('qty_windows')->default(0);
            $table->unsignedInteger('qty_frames')->default(0);
            $table->unsignedInteger('qty_others')->default(0);
            $table->unsignedInteger('qty_total')->default(0);

            // 7/8. Timeline & budget
            $table->string('timeline');
            $table->string('budget')->nullable();

            // 9. Competitor
            $table->string('competitor')->nullable();

            // 10/11/12. Outcome
            $table->enum('interest', ['Low', 'Medium', 'High']);
            $table->boolean('follow_up')->default(false);
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index(['visit_date', 'state']);
            $table->index('mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
