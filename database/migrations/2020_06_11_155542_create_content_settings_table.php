<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('header_logo')->nullable();
            $table->string('header_bg_image')->nullable();
            $table->string('header_f_image')->nullable();
            $table->text('header_h')->nullable();
            $table->text('header_p')->nullable();
            $table->text('about_us_h')->nullable();
            $table->text('about_us_p')->nullable();
            $table->text('our_blogs_h')->nullable();
            $table->text('our_blogs_p')->nullable();
            $table->string('our_blogs_bg_image')->nullable();
            $table->string('our_blogs_rt_image')->nullable();
            $table->string('our_blogs_bl_image')->nullable();
            $table->text('updates_h')->nullable();
            $table->text('updates_p')->nullable();
            $table->text('download_app_h')->nullable();
            $table->text('download_app_p')->nullable();
            $table->string('download_app_bg_image')->nullable();
            $table->string('download_app_r1_image')->nullable();
            $table->string('download_app_r2_image')->nullable();
            $table->text('contact_us_h')->nullable();
            $table->text('location')->nullable();
            $table->string('location_image')->nullable();
            $table->text('phone')->nullable();
            $table->string('phone_image')->nullable();
            $table->text('email')->nullable();
            $table->string('email_image')->nullable();
            $table->string('footer_logo')->nullable();
            $table->text('footer_p')->nullable();
            $table->string('footer_bg_image')->nullable();
            $table->text('copyright')->nullable();
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
        Schema::dropIfExists('content_settings');
    }
}
