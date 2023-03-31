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
        Schema::create('eav', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_attribute_id');
            $table->string('attribute_value');
            $table->unsignedBigInteger('record_id');
            $table->timestamps();

            $table->foreign('entity_attribute_id')->references('id')->on('entity_attributes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eav');
    }
};
