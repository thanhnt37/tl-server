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

            $table->string('code')->unique();
            $table->string('wildcard')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->string('link');
            $table->string('type')->nullable()->default('mp4');
            $table->string('sub_link')->nullable()->default(null);

            $table->string('image')->nullable();
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
