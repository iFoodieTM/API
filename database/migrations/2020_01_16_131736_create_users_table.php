<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->nullable($value = true);
            $table->string('email')->unique();
            $table->string('user_name')->unique()->nullable($value = true);
            $table->string('password', 300);
            $table->string('photo')->nullable($value = true);
            $table->integer('rol');
            $table->string('menu')->nullable($value = true);
            $table->longText('description')->nullable($value = true);
            $table->boolean('banned')->default($value=false);
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
        Schema::dropIfExists('users');
    }
}
