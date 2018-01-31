<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatestoreApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_applications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('version_name')->nullable()->default('');
            $table->string('version_code')->nullable()->default('');
            $table->string('package_name')->nullable()->default('');
            $table->text('description')->nullable()->default('');

            $table->unsignedBigInteger('icon_image_id')->nullable()->default(0);
            $table->unsignedBigInteger('background_image_id')->nullable()->default(0);
            $table->unsignedBigInteger('hit')->nullable()->default(0);

            $table->unsignedBigInteger('apk_package_id')->nullable()->default(0);
            $table->unsignedBigInteger('category_id')->nullable()->default(0);
            $table->unsignedBigInteger('developer_id')->nullable()->default(0);

            $table->timestamp('publish_started_at')->nullable()->default('2000-01-01 00:00:00');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('store_applications', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_applications');
    }
}
