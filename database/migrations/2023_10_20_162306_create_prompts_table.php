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
        Schema::create('prompts', function (Blueprint $table) {
            $table->comment('指令');
            $table->id();
            $table->unsignedBigInteger('group_id')->comment('分组ID');
            $table->string('name')->comment('名称');
            $table->text('content')->comment('内容');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
