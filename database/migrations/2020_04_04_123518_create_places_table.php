<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->string('name',100);
            $table->string('slug',200);
            $table->text('address')->nullable();
            $table->string('image',255)->nullable();
            $table->string('phone',255);
            $table->string('longitude',255);
            $table->string('latitude',255);
            $table->boolean('status',1)->default(0);
            $table->text('tags')->nullable();
            $table->string('from_time',255);
            $table->string('to_time',255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
