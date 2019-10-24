<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('is_receiving');
            $table->bigInteger('master_currency')->unsigned();
            $table->timestamps();
        });

        Schema::table('account', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('user')->onDelete('cascade');
            $table->foreign('master_currency')
                ->references('id')->on('currency')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
