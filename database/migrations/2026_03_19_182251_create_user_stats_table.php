<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_stats', function (Blueprint $table) {
            $table->id();
            $table->date('stat_date')->index()->comment('统计日期');
            $table->unsignedBigInteger('total_user_count')->comment('');
            $table->unsignedBigInteger('total_coin_count')->comment('');
            $table->unsignedBigInteger('new_user_count')->comment('');
            $table->unsignedBigInteger('active_user_count')->comment('');
            $table->timestamp('created_at')->nullable()->comment('统计时间');
            $table->index(['stat_date', 'created_at']);
            $table->comment('用户统计表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stats');
    }
};
