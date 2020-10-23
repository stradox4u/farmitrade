<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaystackSubaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystack_subaccounts', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('settlement_bank');
            $table->string('account_number');
            $table->bigInteger('percentage_charge');
            $table->string('description');
            $table->string('subaccount_code');
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
        Schema::dropIfExists('paystack_subaccounts');
    }
}
