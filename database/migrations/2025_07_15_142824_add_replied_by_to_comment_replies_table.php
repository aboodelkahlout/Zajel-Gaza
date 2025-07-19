<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comment_replies', function (Blueprint $table) {
            //
            $table->enum('replied_by', ['admin', 'hotel_owner'])->after('reply_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_replies', function (Blueprint $table) {
            //
            $table->dropColumn('replied_by');
        });
    }
};
