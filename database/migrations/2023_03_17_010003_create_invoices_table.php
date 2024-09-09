<?php

use App\Enums\ResultStatusBank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->double('quantity', 8, 2)->index();
            $table->enum('status_pay', ResultStatusBank::ALL)->index();
            $table->unsignedBigInteger('coin_id')->index();
            $table->foreign('coin_id')->on('coins')->references('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('invoices');
    }
};
