<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateauthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('authors', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
