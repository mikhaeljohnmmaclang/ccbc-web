<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->foreign(['ministry_id'], 'offerings_ministries_id')->references(['id'])->on('ministries');
            $table->foreign(['transaction_id'], 'offerings_transaction_id')->references(['id'])->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropForeign('offerings_ministries_id');
            $table->dropForeign('offerings_transaction_id');
        });
    }
};
