<?php
/**
 * This is NOT a freeware, use is subject to license terms.
 */

namespace App\Facades;

use App\Services\UploadService;
use Illuminate\Support\Facades\Facade;

/**
 * 上传服务
 *
 * @mixin UploadService
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Upload extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UploadService::class;
    }
}
