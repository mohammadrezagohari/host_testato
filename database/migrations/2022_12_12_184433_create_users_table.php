<?php

use App\Enums\AccessType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('avatar')->default(1);
            $table->string('name')->nullable();
            $table->string('mobile', 11)->unique()->index();
            $table->boolean('is_register')->default(false)->index();
            $table->enum('sex', App\Enums\Sex::ALL)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_student')->default(1);
            $table->enum('access_type', AccessType::ALL)->default(AccessType::Student);
            $table->boolean('is_enable')->default(1);
            $table->foreignId("province_id")->nullable();
            $table->foreignId("grade_id")->persisted()->nullable();
            $table->foreign("grade_id")
                ->on("grades")->references("id");
            $table->foreignId("field_id")->persisted()->nullable();
            $table->foreign("field_id")
                ->on("fields")->references("id");
            $table->foreignId('school_id')->persisted()->nullable();
            $table->foreign("school_id")
                ->on("schools")->references("id");
            $table->foreign("province_id")
                ->on("provinces")->references("id");
            $table->foreignId("city_id")->nullable();
            $table->foreign("city_id")
                ->on("cities")->references("id");
            $table->unsignedBigInteger("familiar_id")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
