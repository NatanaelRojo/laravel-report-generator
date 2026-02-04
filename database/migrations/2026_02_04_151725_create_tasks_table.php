<?php

use App\Enums\TaskStatus;
use App\Models\Project;
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
        if (! Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Project::class)->constrained()->onDelete('cascade');
                $table->string('name');
                $table->text('description')->nullable();
                $table->enum('status', TaskStatus::valuesToArray())->default(TaskStatus::PENDING->value);
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->date('due_date')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
