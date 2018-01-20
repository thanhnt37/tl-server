<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateapplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('app_key');

            $table->boolean('is_blocked')->nullable()->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        $this->updateTimestampDefaultValue('applications', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
