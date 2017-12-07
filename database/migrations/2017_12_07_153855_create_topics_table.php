<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatetopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('topics', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
