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
        Schema::table('levels', function (Blueprint $table) {
            // FUCK: Kill Me Please https://github.com/laravel/framework/issues/8840
            $table->tinyInteger('length')->nullable()->change();
            $table->tinyInteger('epic')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->unsignedTinyInteger('length')->nullable()->change();
            $table->boolean('epic')->nullable()->change();
        });
    }
};
