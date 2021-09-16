<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuesitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prop_quesition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->comment('學年');
            $table->tinyInteger('semester')->comment('學期');
            $table->string('quesition', 1024)->comment('題目');
            $table->text('options')->nullable()->comment('選項');
            $table->tinyInteger('type')->comment('題型');
            $table->string('answer', 100)->comment('解答');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('prop_examination_papers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('試卷名稱');
            $table->integer('create_by');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prop_quesition');
        Schema::dropIfExists('prop_examination_papers');
    }
}
