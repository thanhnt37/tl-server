<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatesingerSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singer_songs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('singer_id');
            $table->unsignedBigInteger('song_id');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('singer_songs', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('singer_songs');
    }
}
