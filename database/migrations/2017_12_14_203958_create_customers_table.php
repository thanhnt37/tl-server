<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatecustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email')->nullable()->default();
            $table->string('address')->nullable()->default();
            $table->string('telephone');
            $table->string('area')->nullable()->default();
            $table->string('agency')->nullable()->default();

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('customers', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
