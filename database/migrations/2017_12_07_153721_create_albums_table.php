<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatealbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('cover_image_id')->nullable()->default(0);
            $table->unsignedBigInteger('background_image_id')->nullable()->default(0);
            $table->unsignedBigInteger('vote')->nullable()->default(0);
            $table->timestamp('publish_at')->nullable()->default('2000-01-01 00:00:00');

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('albums', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
