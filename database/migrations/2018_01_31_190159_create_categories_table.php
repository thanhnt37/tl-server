<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatecategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable()->default('');

            $table->tinyInteger('type')->nullable()->default(0)->comment('0 = application | 1 = game');

            $table->unsignedBigInteger('cover_image_id')->nullable()->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('categories', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
