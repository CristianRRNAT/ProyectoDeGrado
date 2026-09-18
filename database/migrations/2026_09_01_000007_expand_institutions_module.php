<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('payment_type', 30)->nullable()->after('ownership');
            $table->text('cost_notes')->nullable()->after('description');
            $table->text('schedule_notes')->nullable()->after('cost_notes');
        });

        Schema::create('institution_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->string('name', 180);
            $table->string('slug', 190);
            $table->string('unit_type', 50)->default('Facultad');
            $table->text('description')->nullable();
            $table->string('address', 255)->nullable();
            $table->text('schedule_notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['institution_id', 'slug']);
        });

        Schema::table('institution_career', function (Blueprint $table) {
            $table->foreignId('institution_unit_id')->nullable()->after('institution_id')->constrained()->nullOnDelete();
            $table->string('labor_demand', 30)->nullable()->after('duration_text');
            $table->text('labor_demand_notes')->nullable()->after('labor_demand');
            $table->index(['institution_unit_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('institution_career', function (Blueprint $table) {
            $table->dropForeign(['institution_unit_id']);
            $table->dropIndex(['institution_unit_id', 'is_active']);
            $table->dropColumn(['institution_unit_id', 'labor_demand', 'labor_demand_notes']);
        });
        Schema::dropIfExists('institution_units');
        Schema::table('institutions', fn (Blueprint $table) => $table->dropColumn(['payment_type', 'cost_notes', 'schedule_notes']));
    }
};
