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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bitlab_id')
                ->unique();
            $table->string('name');
            $table->string('path')->nullable();
            $table->string('web_url')->nullable();
            $table->string('ssh_url_to_repo');
            $table->smallInteger('star_count');
            $table->smallInteger('forks_count');
            $table->string('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
