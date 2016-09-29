<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raffle_id')->unsigned()->index();
            $table->string('hash')->unique();
            $table->longText('details');
            $table->char('status', 1)->default('R');
            $table->datetime('expires_at')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('raffle_id')->references('id')->on('raffles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
