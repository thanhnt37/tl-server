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

            $table->unsignedBigInteger('os_version_id');
            $table->unsignedBigInteger('sdk_version_id');
            $table->unsignedBigInteger('box_version_id');
            $table->unsignedBigInteger('kara_version_id');
            $table->unsignedBigInteger('application_id');

            $table->timestamps();
            $table->softDeletes();
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
