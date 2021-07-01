<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no')->nullable();
            $table->string('party_name')->nullable();
            $table->string('po_no')->unique()->nullable();
            $table->string('bill_no')->unique()->nullable();
            $table->date('bill_date')->nullable();
            $table->float('bill_gross_value')->nullable();
            $table->string('currency')->nullable();
            $table->text('details')->nullable();
            $table->date('receipt_date_by_tr')->nullable();
            $table->text('tr_remarks')->nullable();
            $table->integer('payment_proposal')->comment('1=Yes, 0=No')->nullable();
            $table->integer('approved_for_payment')->comment('1=Yes, 0=No')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_handover_date')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
