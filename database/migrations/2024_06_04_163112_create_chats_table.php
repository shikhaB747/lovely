<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('partner_id');
            $table->text('message')->nullable()->comment('it will be contained  Text');
            $table->string('image',250)->nullable()->comment('it will be contained Images, Videos, Sticker, Audio');
            $table->tinyInteger('message_type')->comment('1-Text, 2-Images, 3-Audio')->default('1');
            $table->string('chat_room',100)->nullable();
            $table->tinyInteger('is_read')->default(0);
             
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('partner_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('chats');
    }
}
