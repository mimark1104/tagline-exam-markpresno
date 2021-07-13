<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('payment_id');
            $table->decimal("total",10,2);
            $table->timestamps();

            $table->foreign("user_id")
            ->on('users')
            ->references('id')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign("status_id")
            ->on('statuses')
            ->references('id')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign("payment_id")
            ->on('payments')
            ->references('id')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
