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
        Schema::table('commitments', function (Blueprint $table) {
            $table->foreign(['member_id'], 'commitments_members_id')->references(['id'])->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commitments', function (Blueprint $table) {
            $table->dropForeign('commitments_members_id');
        });
    }
};
