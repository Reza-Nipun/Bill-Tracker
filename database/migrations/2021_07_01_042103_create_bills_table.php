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
            $table->string('po_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->date('bill_date')->nullable();
            $table->float('bill_gross_value')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('plant_id')->nullable();
            $table->text('details')->nullable();
            $table->text('tr_remarks')->nullable();
            $table->text('ap_remarks')->nullable();
            $table->text('return_to_ap_remarks')->nullable();
            $table->integer('status')->comment('100=Return To AP, 101=Receipt by AP, 102=AP Sent to TR, 200=Receipt by TR, 300=Payment Proposal, 301=Approved for Payment, 400=Check Printed, 401=Check Handover')->nullable();
            $table->date('return_to_ap_date')->nullable();
            $table->date('receipt_by_ap_date')->nullable();
            $table->date('ap_sent_to_tr_date')->nullable();
            $table->date('receipt_date_by_tr')->nullable();
            $table->date('payment_proposal_date')->nullable();
            $table->date('approved_for_payment_date')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_print_date')->nullable();
            $table->date('cheque_handover_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('plant_id')->references('id')->on('plants');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
