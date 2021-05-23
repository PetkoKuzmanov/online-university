<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_student', function (Blueprint $table) {
            $table->primary(['course_id', 'student_id']);
            $table->timestamps();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_student');
    }
}
