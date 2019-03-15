<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentAssignmentFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_assignment_form', function (Blueprint $table) {
            $table->integer('a_id')->nullable(false)->unsigned()->index();
            $table->foreign('a_id')->references('id')->on('assignments')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('a_form_id')->nullable(false)->unsigned()->index();
            $table->foreign('a_form_id')->references('id')->on('assignment_forms')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['a_id', 'a_form_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_assignment_form');
    }
}
