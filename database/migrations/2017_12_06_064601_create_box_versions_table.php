<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateboxVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_versions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        $this->updateTimestampDefaultValue('box_versions', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('box_versions');
    }
}
