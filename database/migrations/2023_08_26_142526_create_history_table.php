<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('status');
            $table->string('date');
            $table->uuid('product_id', 120)->nullable();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('quantity');
            $table->uuid('created_by', 120);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history');
    }
}
