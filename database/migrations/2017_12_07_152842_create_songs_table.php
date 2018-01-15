<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatesongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('code')->nullable();
            $table->string('wildcard')->nullable();
            $table->string('name');
            $table->text('description')->nullable();

            $table->string('file_name')->nullable();
            $table->string('link')->nullable();
            $table->string('type')->nullable()->default('mp4');
            $table->tinyInteger('mode_play')->nullable()->default(0);
            $table->string('sub_link')->nullable()->default(null);

            $table->unsignedBigInteger('cover_image_id')->nullable()->default(0);
            $table->unsignedBigInteger('view')->nullable()->default(0);
            $table->unsignedBigInteger('play')->nullable()->default(0);
            $table->unsignedBigInteger('vote')->nullable()->default(0);

            $table->unsignedBigInteger('author_id')->nullable()->default(0);
            $table->timestamp('publish_at')->nullable()->default('2000-01-01 00:00:00');

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('songs', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
