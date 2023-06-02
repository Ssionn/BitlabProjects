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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name');
            $table->string('username');
            $table->string('ref');
            $table->string('ref_type');
            $table->string('action_name');
            $table->string('commit_to');
            $table->string('commit_title');
            $table->string('target_type')->nullable();
            $table->string('target_title')->nullable();
            $table->string('target_iid')->nullable();
            $table->string('project_web_url');
            $table->string('project_name_with_namespace');
            $table->string('project_branch');
            $table->smallInteger('project_star_count');
            $table->smallInteger('project_forks_count');
            $table->string('last_activity_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
