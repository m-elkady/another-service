<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('user_id');
      $table->string('user_name', 100);
      $table->integer('user_ldap')->unsigned();
      $table->integer('user_date');
      $table->string('user_iban', 150)->nullable();
      $table->string('user_bic', 50)->nullable();
      $table->boolean('user_status');
      $table->integer('user_last')->unsigned()->nullable();
      $table->integer('user_last_update')->unsigned()->nullable();
      $table->integer('user_zabbix')->default(0);
      $table->boolean('report')->default(0);
      $table->boolean('billing')->default(0);
      $table->float('user_vat')->default(20);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('users');
  }

}
