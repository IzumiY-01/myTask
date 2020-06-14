<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('category');
            $table->string('object_month');
            $table->date('due_date');
            $table->string('name_work');
            $table->integer('dept_check');
            $table->integer('due_pattern')->nullable();
            $table->integer('due_schedule')->nullable();
            $table->integer('start_pattern')->nullable();
            $table->integer('start_schedule')->nullable();
            $table->string('free');
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
        Schema::dropIfExists('tasks');
    }
}
