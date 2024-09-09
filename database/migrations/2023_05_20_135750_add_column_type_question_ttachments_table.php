<?php

use App\Enums\AttachmentType;
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
        Schema::table('question_attachments', function (Blueprint $table) {
            $table->enum("type", AttachmentType::ALL)->default(AttachmentType::IMAGE)->index()
                ->after("file_url");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
