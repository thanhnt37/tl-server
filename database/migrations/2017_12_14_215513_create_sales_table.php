<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatesalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('box_id');

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('sales', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
