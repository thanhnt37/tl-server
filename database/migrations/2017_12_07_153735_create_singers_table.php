<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatesingersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('wildcard')->nullable();
            $table->string('name');
            $table->string('slug_name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('cover_image_id')->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('singers', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('singers');
    }
}
