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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('short_description');
            $table->decimal('price', 5, 2);
            $table->unsignedInteger('range');
            $table->unsignedInteger('contract_duration');
            $table->boolean('drivers_license');
            $table->boolean('motorway');
            $table->boolean('top_box');
            $table->foreignId('type_id')->constrained();
            $table->foreignId('usecase_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
