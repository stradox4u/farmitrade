<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyerIsRatedAndFarmerIsRatedToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('buyer_is_rated')->default(false)->after('transaction_status');
            $table->boolean('farmer_is_rated')->default(false)->after('buyer_is_rated');
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
            $table->dropColumn('buyer_is_rated');
            $table->dropColumn('farmer_is_rated');
        });
    }
}
