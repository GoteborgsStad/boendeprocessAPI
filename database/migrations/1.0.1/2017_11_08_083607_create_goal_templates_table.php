<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false)->default();
            $table->text('description')->nullable()->default(null);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);
            $table->string('color')->nullable()->default(null);
            $table->integer('goal_category_id')->nullable(false)->unsigned()->index();
            $table->foreign('goal_category_id')->references('id')->on('goal_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('goal_status_id')->nullable(false)->unsigned()->index();
            $table->foreign('goal_status_id')->references('id')->on('goal_statuses')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('goal_templates');
    }
}
