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
        Schema::create('permission__modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->boolean('add_access')->default(false);
            $table->boolean('view_access')->default(false);
            $table->boolean('edit_access')->default(false);
            $table->boolean('delete_access')->default(false);
            $table->timestamp('updated_at')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission__modules');
    }
};