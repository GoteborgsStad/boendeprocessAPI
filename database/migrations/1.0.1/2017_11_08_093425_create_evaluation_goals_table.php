<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goal_id')->nullable(false)->unsigned()->index();
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('evaluation_id')->nullable(false)->unsigned()->index();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('evaluation_goals');
    }
}
