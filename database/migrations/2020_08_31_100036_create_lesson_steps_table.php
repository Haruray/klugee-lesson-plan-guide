<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('klugee_class_id');
            $table->integer('syllabus_id');
            $table->string('phase',100); //pre,during, or post
            $table->string('step',500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_steps');
    }
}
