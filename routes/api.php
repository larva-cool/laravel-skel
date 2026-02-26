<?php

/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * RESTFul API version 1.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    /**
     * 公共接口
     */
    Route::group(['prefix' => 'common', 'as' => 'common.'], function (Illuminate\Contracts\Routing\Registrar $registrar) {
        $registrar->any('fpm', [\App\Http\Controllers\Api\V1\CommonController::class, 'fpm'])->name('fpm'); // reload fpm
        $registrar->post('sms-captcha', [\App\Http\Controllers\Api\V1\CommonController::class, 'smsCaptcha'])->name('sms_captcha'); // 短信验证码
        $registrar->post('mail-captcha', [\App\Http\Controllers\Api\V1\CommonController::class, 'mailCaptcha'])->name('mail_captcha'); // 邮件验证码
        // 增加缓存Header
        $registrar->group(['middleware' => 'cache.headers:public;max_age=2628000;etag'], function (Illuminate\Contracts\Routing\Registrar $registrar) {
            $registrar->get('dict', [\App\Http\Controllers\Api\V1\CommonController::class, 'dict'])->name('dict'); // 字典列表
            $registrar->get('area', [\App\Http\Controllers\Api\V1\CommonController::class, 'area'])->name('area'); // 地区列表
            $registrar->get('source-types', [\App\Http\Controllers\Api\V1\CommonController::class, 'sourceTypes'])->name('source_types'); // 获取 Source Types
            $registrar->get('settings', [\App\Http\Controllers\Api\V1\CommonController::class, 'settings'])->name('settings'); // 系统配置
        });
    });

    /**
     * 注册接口
     */
    Route::group(['prefix' => 'register', 'as' => 'register.'], function (Illuminate\Contracts\Routing\Registrar $registrar) {
        $registrar->post('exists', [\App\Http\Controllers\Api\V1\RegisterController::class, 'exists'])->name('exists'); // 账号邮箱手机号检查
        $registrar->post('phone-register', [\App\Http\Controllers\Api\V1\RegisterController::class, 'phoneRegister'])->name('phone'); // 手机号注册
        $registrar->post('', [\App\Http\Controllers\Api\V1\RegisterController::class, 'emailRegister'])->name('email'); // 邮箱注册
    });

    /**
     * 登录认证授权
     */
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function (Illuminate\Contracts\Routing\Registrar $registrar) {
        $registrar->post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'passwordLogin'])->name('password_login'); // 密码授权
        $registrar->post('phone-login', [\App\Http\Controllers\Api\V1\AuthController::class, 'phoneLogin'])->name('phone_login'); // 短信验证码授权
        $registrar->post('wx-login', [\App\Http\Controllers\Api\V1\AuthController::class, 'wxLogin'])->name('wx_login'); // 微信公众号授权登录
        $registrar->post('apple-login', [\App\Http\Controllers\Api\V1\AuthController::class, 'appleLogin'])->name('apple_login'); // Apple 登录授权
        $registrar->post('refresh-token', [\App\Http\Controllers\Api\V1\AuthController::class, 'refreshToken'])->name('refresh_token'); // 重新签发个人访问令牌
        $registrar->get('tokens', [\App\Http\Controllers\Api\V1\AuthController::class, 'tokens'])->name('tokens'); // 查询已经签发的所有令牌
        $registrar->delete('tokens/{tokenId}', [\App\Http\Controllers\Api\V1\AuthController::class, 'destroyToken'])->name('destroy_token'); // 销毁指定的 Token
        $registrar->delete('tokens', [\App\Http\Controllers\Api\V1\AuthController::class, 'destroyCurrentAccessToken'])->name('destroy_current_token'); // 销毁当前正在使用的 Token
        $registrar->post('phone-reset-password', [\App\Http\Controllers\Api\V1\AuthController::class, 'resetPasswordByPhone'])->name('reset_password_by_phone'); // 通过手机重置用户登录密码
    });

});
