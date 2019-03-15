<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false)->default();
            $table->text('description')->nullable()->default(null);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);
            $table->string('image_url')->nullable()->default(null);
            $table->string('color')->nullable()->default(null);
            $table->integer('assignment_category_id')->nullable(false)->unsigned()->index();
            $table->foreign('assignment_category_id')->references('id')->on('assignment_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('assignment_status_id')->nullable(false)->unsigned()->index();
            $table->foreign('assignment_status_id')->references('id')->on('assignment_statuses')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('assignment_templates');
    }
}
