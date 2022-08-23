<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config()->get('taskmanager.table_prefix').'completed', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('task_id')->unsigned();
            $table->foreign('task_id')
                ->references('id')
                ->on(config()->get('taskmanager.table_prefix').'tasks')
                ->onDelete('cascade');

            $table->date('start_date');

            $table->dateTime('completed_at');

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
        Schema::dropIfExists(config()->get('taskmanager.table_prefix').'completed');
    }
};
