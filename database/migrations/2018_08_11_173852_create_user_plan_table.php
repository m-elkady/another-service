<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPlanTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('user_plan', function (Blueprint $table) {
      $table->integer('plan_id');
      $table->integer('user_id');
      $table->integer('plan_start_date');
      $table->integer('plan_end_date');
      $table->boolean('plan_billed');
      $table->index('plan_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('user_plan');
  }

}
