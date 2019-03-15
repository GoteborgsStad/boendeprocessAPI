<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(false);
            $table->string('color')->nullable()->default(null);
            $table->integer('faq_category_id')->nullable(false)->unsigned()->index();
            $table->foreign('faq_category_id')->references('id')->on('faqs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('operand_id')->nullable(false)->unsigned()->index();
            $table->foreign('operand_id')->references('id')->on('operands')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->nullable(false)->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('faqs');
    }
}
