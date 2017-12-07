<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreategenreSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_songs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('song_id');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('genre_songs', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_songs');
    }
}
