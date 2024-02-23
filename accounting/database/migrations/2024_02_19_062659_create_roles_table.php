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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('desc')->nullable()->default('-');

            $table->bigInteger('created_by');
            $table->dateTime('created_at');
            $table->bigInteger('modified_by')->nullable();
            $table->dateTime('modified_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('is_delete')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
