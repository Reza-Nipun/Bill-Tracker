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
            $table->string('tracking_no')->unique()->nullable();
            $table->string('party_name')->nullable();
            $table->string('po_no')->unique()->nullable();
            $table->string('bill_no')->unique()->nullable();
            $table->date('bill_date')->nullable();
            $table->float('bill_gross_value')->nullable();
            $table->string('currency')->nullable();
            $table->unsignedBigInteger('plant_id')->nullable();
            $table->text('details')->nullable();
            $table->date('receipt_date_by_tr')->nullable();
            $table->text('tr_remarks')->nullable();
            $table->integer('status')->comment('0=Received by TR, 1=Payment Proposal, 2=Approved for Payment, 3=Check Handover')->nullable();
            $table->date('payment_proposal_date')->nullable();
            $table->date('approved_for_payment_date')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_handover_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('plant_id')->references('id')->on('plants');
            $table->foreign('user_id')->references('id')->on('users');
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
