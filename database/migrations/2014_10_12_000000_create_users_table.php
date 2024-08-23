<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id(); // Shorthand for unsignedBigInteger primary key auto-incrementing

            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone', 20)->unique()->nullable();

            $table->date('birthday')->nullable(); // Changed to lowercase 'date'

            $table->string('gender', 10)->nullable();

            $table->integer('age')->default(0);

            $table->text('location')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();

            $table->string('image_profile', 255)->nullable();

            $table->tinyInteger('is_premium')->default(0)->comment('0-non_premium_user , 1-premium_user');

            $table->string('premium_expiry_date', 20)->nullable();
            
            $table->integer('total_likes')->default(0);

            $table->integer('total_super_likes_points')->default(0);

            $table->integer('available_spotlight')->default(0);

            $table->integer('available_super_likes')->default(0);

            $table->string('blocked_ids')->nullable();

            $table->string('not_for_me_ids')->nullable();

            $table->string('page', 40)->nullable(); // Changed to tinyInteger

            $table->tinyInteger('status')->comment('0-active, 1-inactive, 2-deleted')->default(0);

            $table->string('device_token')->nullable();

            $table->tinyInteger('device_type')->default(1)->comment('1-Android,2-IOS')->nullable();

            $table->tinyInteger('user_verified')->comment('0-not Verified, 1-Verified')->default(0)->nullable();

            $table->tinyInteger('incognito_mode')->comment('0-no, 1-yes')->default(0)->nullable();

            $table->integer('snooze_hour')->comment('Snooze hours')->default(0)->nullable(); // save hour for snooze_hour

            $table->dateTime('snooze_from')->nullable();

            $table->dateTime('snooze_till')->nullable();

            $table->tinyInteger('travel_mode')->comment('0-no, 1-yes')->default(0)->nullable();

            $table->string('password')->nullable();

            $table->text('social_id')->nullable();

            $table->string('social_id_type', 10)->nullable();

            $table->tinyInteger('social_image')->comment('0-no, 1-yes')->default(0)->nullable();



            $table->text('remember_token')->nullable();

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
        Schema::dropIfExists('report_supports');
        Schema::dropIfExists('users');
    }
}
