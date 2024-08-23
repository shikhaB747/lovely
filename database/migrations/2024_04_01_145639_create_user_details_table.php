<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('profile_prompt')->nullable();
            $table->string('profile_images')->nullable();
            $table->string('looking_for')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('like_to_date')->nullable();
            $table->string('about_me')->nullable();
            $table->string('job_role')->nullable();
            $table->string('height')->nullable();
            $table->string('education')->nullable();
            $table->string('do_work_out')->nullable();
            $table->string('do_drink')->nullable();
            $table->string('do_smoke')->nullable();
            $table->string('have_children')->nullable();
            $table->string('zodiac_sign')->nullable();
            $table->string('identify_religion')->nullable();
            $table->string('political_leanings')->nullable();
            $table->string('all_interests')->nullable();
            $table->string('language')->nullable();
            $table->integer('profile_score')->default(0);

            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();
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
