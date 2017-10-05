<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type');
            $table->integer('number')->nullable();
            $table->integer('year')->nullable();
            $table->integer('adv_number')->nullable();
            $table->integer('adv_year')->nullable();
            $table->string('subject');
            $table->string('court')->nullable();
            $table->string('room')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('issue_person', function (Blueprint $table) {
            $table->integer('issue_id')->unsigned()->index();
            $table->foreign('issue_id')->references('id')->on('issues');
            $table->integer('person_id')->unsigned()->index();
            $table->foreign('person_id')->references('id')->on('people');
            $table->smallInteger('person_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_person');
        Schema::dropIfExists('issues');
    }
}
