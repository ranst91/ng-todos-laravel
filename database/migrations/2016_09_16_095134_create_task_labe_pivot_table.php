<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskLabePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_label', function (Blueprint $table) {
            $table->integer('task_id')->unsigned();
            $table->integer('label_id')->unsigned();

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['task_id', 'label_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task_label');
    }
}
