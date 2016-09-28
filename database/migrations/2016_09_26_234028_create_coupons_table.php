<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raffle_id')->unsigned()->index();
            $table->integer('number')->unsigned();
            $table->string('code')->nullable();
            $table->char('status', 1)->default('F');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('raffle_id')->references('id')->on('raffles');
            $table->unique(['raffle_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
