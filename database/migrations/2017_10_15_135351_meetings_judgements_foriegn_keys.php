<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MeetingsJudgementsForiegnKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meetings', function($table) {
            $table->foreign('issue_id')->references('id')->on('issues');
            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('parent_id')->references('id')->on('meetings');
            $table->foreign('judgement_id')->references('id')->on('judgements');
        });

        Schema::table('judgements', function($table) {
            $table->foreign('meeting_id')->references('id')->on('meetings');
            $table->foreign('issue_id')->references('id')->on('issues');
            $table->foreign('person_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
