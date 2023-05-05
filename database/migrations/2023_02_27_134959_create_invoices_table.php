<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('product');
            $table->foreignId('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('discount',$precision = 8, $scale = 2);
            $table->string('rate_vat');
            $table->decimal('value_vat', $precision = 8, $scale = 2);
            $table->decimal('Total', $precision = 8, $scale = 2);
            $table->decimal('Amount_collection', $precision = 8, $scale = 2)->nullable();
            $table->decimal('Amount_commission', $precision = 8, $scale = 2);
            $table->string('status',50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
