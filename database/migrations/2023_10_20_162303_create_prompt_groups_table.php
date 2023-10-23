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
        Schema::create('prompt_groups', function (Blueprint $table) {
            $table->comment('指令分组');
            $table->id();
            $table->string('name')->comment('名称');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_groups');
    }
};
