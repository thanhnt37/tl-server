<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateosVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('os_versions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        $this->updateTimestampDefaultValue('os_versions', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('os_versions');
    }
}
