<?php

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
        Schema::create('field_unit', function (Blueprint $table) {
            $table->unsignedBigInteger('field_id')->index();
            $table->unsignedBigInteger('unit_id')->index();
            $table->foreign("field_id")->on("fields")->references("id");
            $table->foreign("unit_id")->on("units")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_unit');
    }
};
