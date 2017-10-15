<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judgements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_id')->unsigned()->index();
            $table->integer('issue_id')->unsigned()->index();
            $table->integer('person_id')->nullable()->unsigned()->index();
            $table->boolean('active')->default(1);
            $table->boolean('present')->default(0);
            $table->tinyInteger('type');
            $table->integer('record')->nullable();
            $table->smallInteger('year')->nullable();
            $table->date('date');
            $table->string('body');
            $table->smallInteger('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('judgements');
        Schema::enableForeignKeyConstraints();
    }
}
