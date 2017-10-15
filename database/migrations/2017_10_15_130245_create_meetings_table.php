<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_id')->unsigned()->index();
            $table->integer('person_id')->nullable()->unsigned()->index();
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->integer('judgement_id')->nullable()->unsigned()->index();
            $table->integer('level');
            $table->integer('role')->nullable();
            $table->date('date');
            $table->string('decision');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('meetings');
        Schema::enableForeignKeyConstraints();
    }
}
