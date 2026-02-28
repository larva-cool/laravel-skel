<?php

/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

use App\Models\User\Nickname;
use App\Support\FileHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! app()->environment('testing')) {// testing 跳过
            ini_set('memory_limit', '-1');
            // 写入随机昵称
            $data = FileHelper::json(database_path('data/nickname-20251129.json'));
            $nicknames = [];
            foreach ($data as $key => $val) {
                $nicknames[] = ['nickname' => $val];
                // 1000个一组写入数据库
                if ($key % 1000 === 0) {
                    Nickname::insert($nicknames);
                    $nicknames = [];
                }
            }
            Nickname::insert($nicknames);
            // 释放内存
            $data = $nicknames = null;
            unset($data, $nicknames);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Nickname::truncate();
    }
};
