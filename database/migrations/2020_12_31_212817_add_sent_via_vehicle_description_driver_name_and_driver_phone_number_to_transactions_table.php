<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentViaVehicleDescriptionDriverNameAndDriverPhoneNumberToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('sent_via')->after('delivery_timeframe')->nullable();
            $table->string('vehicle_description')->after('sent_via')->nullable();
            $table->string('bearer_name')->after('vehicle_description')->nullable();
            $table->string('bearer_phone_number')->after('bearer_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('sent_via');
            $table->dropColumn('vehicle_description');
            $table->dropColumn('bearer_name');
            $table->dropColumn('bearer_phone_number');
        });
    }
}
