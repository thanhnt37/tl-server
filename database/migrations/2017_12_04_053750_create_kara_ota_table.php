<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatekaraOtaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kara_ota', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('os_version');
            $table->string('box_version');
            $table->unsignedBigInteger('kara_version_id');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('kara_ota', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kara_ota');
    }
}
