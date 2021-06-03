<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_student', function (Blueprint $table) {
            $table->primary(['assignment_id', 'student_id']);
            $table->timestamps();

            //Student uploaded file
            //Grade

            $table->unsignedBigInteger('assignment_id');
            $table->foreign('assignment_id')->references('id')->on('assignments')
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
        Schema::dropIfExists('assignment_student');
    }
}
