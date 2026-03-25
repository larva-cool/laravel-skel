<?php

/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Model;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * 用户统计
 *
 * @property int $id ID
 * @property Carbon $stat_date 统计日期
 * @property int $total_user_count 用户总数
 * @property int $total_coin_count 金币总数
 * @property int $new_user_count 新注册用户数
 * @property int $active_user_count 活跃用户数
 * @property int $coin_trade_count 金币交易总数
 * @property Carbon $created_at 统计时间
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserStat extends Model
{
    // 时间定义
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'stat_date', 'total_user_count', 'total_coin_count', 'new_user_count', 'active_user_count', 'coin_trade_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'stat_date' => 'date:Y-m-d',
            'total_user_count' => 'integer',
            'total_coin_count' => 'integer',
            'new_user_count' => 'integer',
            'active_user_count' => 'integer',
            'coin_trade_count' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    /**
     * 查询最近几天注册的用户数
     */
    public static function getRecentDaysRegistration(int|string $days): int
    {
        return (int) self::query()->whereBetween('stat_date', [Carbon::now()->subDays((int) $days), Carbon::now()])->sum('new_user_count');
    }

    /**
     * 查询今天注册用户数
     */
    public static function getTodayRegistration(): int
    {
        $item = self::query()->whereDate('stat_date', Carbon::now())->first();
        if ($item) {
            return $item->new_user_count;
        }

        return User::query()->whereDate('created_at', Carbon::now())->count();
    }
}
