<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('imei')->unique();
            $table->string('serial')->unique();

            $table->string('model')->nullable()->default('');
            $table->string('os_version_id')->nullable()->default('');
            $table->string('sdk_version_id')->nullable()->default('');

            $table->boolean('is_activated')->nullable()->default(true);
            $table->timestamp('activation_date')->nullable()->default('2000-01-01 00:00:00');

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('boxes', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes');
    }
}
