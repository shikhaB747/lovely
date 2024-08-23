<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_plans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('membership_id');

            $table->date('purchase_date');

            $table->date('start_date');
            $table->date('end_date');

            $table->string('title', 50)->nullable();

            $table->decimal('price', 10, 2);
            $table->tinyInteger('status')->comment('0-active, 1-inactive, 2-cancelled')->default(0); //status

            $table->text('txn_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('membership_id')->references('id')->on('membership_plans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchased_plans');
    }
}
