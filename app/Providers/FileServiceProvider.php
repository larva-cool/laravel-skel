<?php

/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

namespace App\Providers;

use App\Services\FileService;
use Illuminate\Support\ServiceProvider;

/**
 * 文件服务提供器
 *
 * @author Tongle Xu <xutongle@msn.com>
 */
class FileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 注册文件服务
        $this->app->singleton(FileService::class, function () {
            return new FileService;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
