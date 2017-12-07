<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreategenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('genres', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genres');
    }
}
