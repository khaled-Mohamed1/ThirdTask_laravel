<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->string('type');
            $table->float('amount');
            $table->dateTime('operation_date');
            $table->string('reason');
            $table->string('file');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
};
