<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prop_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment("名稱");
            $table->string('email', 255)->comment("帳號");
            $table->string('password', 255)->comment("密碼");
            $table->string('auth', 255)->comment("角色");
            $table->string('language', 255)->comment("語系");
            $table->timestamp('last_login');
            $table->string('remember_token', 100)->nullable();
            $table->boolean('status')->default(false);

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
        Schema::dropIfExists('prop_users');
    }
}
