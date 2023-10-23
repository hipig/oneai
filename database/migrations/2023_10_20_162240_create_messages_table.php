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
        Schema::create('messages', function (Blueprint $table) {
            $table->comment('聊天记录');
            $table->id();
            $table->unsignedBigInteger('chat_id')->comment('会话ID');
            $table->string('type', 64)->comment('类型');
            $table->mediumText('content')->nullable()->comment('内容');
            $table->softDeletes()->comment('软删除时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
