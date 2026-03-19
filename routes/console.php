<?php
/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 清理模型
Schedule::command('model:prune')->daily();

// 队列健康指标
Schedule::command('horizon:snapshot')->everyFiveMinutes();

if (! app()->isProduction()) {
    Schedule::command('telescope:prune --hours=24')->daily();
}
