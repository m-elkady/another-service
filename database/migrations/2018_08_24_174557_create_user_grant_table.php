<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGrantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_grant', function (Blueprint $table) {
            $table->integer('grant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['grant_id', 'user_id']);
            
            $table->foreign('grant_id')->references('grant_id')->on('grants')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_grant');
    }
}
