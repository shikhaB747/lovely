<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
            $table->string('new_matches',     50)->nullable();
            $table->string('expiring_matches',50)->nullable();
            $table->string('new_messages',    50)->nullable();
            $table->string('tips',            50)->nullable();
            $table->string('survey_feedback', 50)->nullable();

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
        Schema::dropIfExists('notification_preferences');
    }
}
