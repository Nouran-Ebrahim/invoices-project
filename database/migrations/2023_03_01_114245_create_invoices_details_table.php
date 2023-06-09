<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('product',50);
            $table->string('section',999);
            $table->string('status',50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->string('user',300);
            $table->date('Payment_Date')->nullable();
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
        Schema::dropIfExists('invoices_details');
    }
}
