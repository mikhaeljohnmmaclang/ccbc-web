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
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('voucher_number');
            $table->bigInteger('ministry_id')->nullable()->index('expenses_ministries_id');
            $table->string('name');
            $table->text('descriptions')->nullable();
            $table->date('date');
            $table->double('amount')->unsigned()->nullable();
            $table->bigInteger('recorded_by')->nullable()->index('expenses_user_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
