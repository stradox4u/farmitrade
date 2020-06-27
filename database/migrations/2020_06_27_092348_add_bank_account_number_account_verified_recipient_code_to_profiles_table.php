<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankAccountNumberAccountVerifiedRecipientCodeToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('bank');
            $table->string('account_number');
            $table->boolean('account_verified')->default(false);
            $table->string('recipient_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('bank');
            $table->dropColumn('account_number');
            $table->dropColumn('account_verified');
            $table->dropColumn('recipient_code');
        });
    }
}
