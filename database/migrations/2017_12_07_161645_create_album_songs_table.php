<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatealbumSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_songs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('album_id');
            $table->unsignedBigInteger('song_id');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('album_songs', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_songs');
    }
}
