<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatekaraVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kara_versions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('application_id')->default(0);
            $table->string('version')->unique();
            $table->string('name');

            $table->text('description')->nullable()->default('');
            $table->bigInteger('apk_package_id')->nullable()->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('kara_versions', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kara_versions');
    }
}
