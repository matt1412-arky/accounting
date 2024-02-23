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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 255);
            $table->string('password', 255);
            $table->bigInteger('role_id');
            $table->integer('login_attempt');
            $table->boolean('is_locked');
            $table->string('email');

            $table->bigInteger('created_by');
            $table->dateTime('created_at');
            $table->bigInteger('modified_by')->nullable();
            $table->dateTime('modified_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('is_delete')->default(false);

            $table->index('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
