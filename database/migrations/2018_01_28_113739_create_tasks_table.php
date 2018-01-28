<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
		    $table->increments('id');
		    $table->string('type');
		    $table->string('content');
		    $table->integer('sort_order');
		    $table->boolean('done');
		    $table->dateTime('date_created');
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
