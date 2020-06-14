<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('task_id');
            $table->string('object_month');
            $table->integer('status')->default(1);
            $table->date('start_date');
            $table->date('due_date');
            $table->date('request_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('check_date')->nullable();
            $table->string('name_check')->nullable();
            $table->date('dept_date')->nullable();
            
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
        Schema::dropIfExists('histories');
    }
}
