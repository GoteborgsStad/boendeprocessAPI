<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentTemplateAssignmentFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_template_assignment_form', function (Blueprint $table) {
            $table->integer('a_t_id')->nullable(false)->unsigned()->index();
            $table->foreign('a_t_id')->references('id')->on('assignment_templates')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('a_f_id')->nullable(false)->unsigned()->index();
            $table->foreign('a_f_id')->references('id')->on('assignment_forms')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['a_t_id', 'a_f_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_template_assignment_form');
    }
}
