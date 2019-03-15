<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body')->nullable()->default(null);
            $table->tinyInteger('rating')->nullable()->default(null);
            $table->integer('evaluation_id')->nullable(false)->unsigned()->index();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('evaluation_answer_category_id')->nullable(false)->unsigned()->index();
            $table->foreign('evaluation_answer_category_id')->references('id')->on('evaluation_answer_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('evaluation_answers');
    }
}
