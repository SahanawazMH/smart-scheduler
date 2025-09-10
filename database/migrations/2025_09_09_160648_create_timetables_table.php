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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('classroom_id')->constrained('classrooms');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('cascade'); //can be for evey student for the section
            $table->foreignId('student_group_id')->nullable()->constrained('student_groups')->onDelete('cascade'); // can be for only for the group section
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
