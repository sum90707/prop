<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperAndRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prop_paper', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('試卷名稱');
            $table->string('remark', 100)->nullable()->defult(null)->comment('備註');
            $table->integer('create_by');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->unique('name');
        });


        Schema::create('prop_paper_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quesition_id')->comment('題目ID');
            $table->integer('paper_id')->comment('試卷ID');
            $table->integer('create_by');
            $table->boolean('status')->default(true);
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
        
        Schema::dropIfExists('prop_paper');
        Schema::dropIfExists('prop_paper_relation');
    }
}
