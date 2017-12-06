<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatesdkVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdk_versions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        $this->updateTimestampDefaultValue('sdk_versions', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdk_versions');
    }
}
