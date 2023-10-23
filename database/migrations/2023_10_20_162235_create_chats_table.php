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
        Schema::create('chats', function (Blueprint $table) {
            $table->comment('会话');
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->string('name')->comment('名称');
            $table->json('config')->comment('配置');
            $table->softDeletes()->comment('软删除时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
