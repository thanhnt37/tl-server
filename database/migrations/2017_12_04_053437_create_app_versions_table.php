<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateAppVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('application_id')->default(0);
            $table->string('version');
            $table->string('name');

            $table->text('description')->nullable()->default('');
            $table->bigInteger('apk_package_id')->nullable()->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('app_versions', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_versions');
    }
}
