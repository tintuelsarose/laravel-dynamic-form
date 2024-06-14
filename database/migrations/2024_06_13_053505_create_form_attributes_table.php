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
        if (!Schema::hasTable('form_attributes')) {
            Schema::create('form_attributes', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('label');
                $table->string('type');
                $table->boolean('active')->default(1);
                $table->foreignId('id_forms');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_attributes');
    }
};
