<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('display_name')->nullable()->default(null);
            $table->string('email')->nullable(false)->default()->unique();
            $table->tinyInteger('sex')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('street_address')->nullable()->default(null);
            $table->string('zip_code')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('home_phone_number')->nullable()->default(null);
            $table->string('cell_phone_number')->nullable()->default(null);
            $table->string('image_url')->nullable()->default(null);
            $table->string('color')->nullable()->default(null);
            $table->integer('user_id')->nullable()->unsigned()->index()->unique();
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
        Schema::dropIfExists('user_details');
    }
}
