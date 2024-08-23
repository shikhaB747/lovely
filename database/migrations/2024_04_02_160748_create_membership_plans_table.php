<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->integer('super_likes_count')->nullable();
            $table->integer('spot_light_count')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('discount')->nullable();
            $table->string('duration')->comment('to show in front')->nullable();
            $table->string('description')->nullable();
            $table->integer('validity')->comment('in days-for calculation')->default(1);
            $table->tinyInteger('status')->comment('0-active, 1-inactive')->default(0);
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
        Schema::dropIfExists('membership_plans');
    }
}
