<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateAppOtaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_ota', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('os_version_id');
            $table->unsignedBigInteger('sdk_version_id');
            $table->unsignedBigInteger('box_version_id');
            $table->unsignedBigInteger('kara_version_id');

            $table->timestamps();
            $table->softDeletes();
        });

        $this->updateTimestampDefaultValue('app_ota', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_ota');
    }
}
