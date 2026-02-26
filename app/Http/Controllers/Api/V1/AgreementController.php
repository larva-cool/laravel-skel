<?php

/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enum\DictCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AgreementResource;
use App\Models\Agreement\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 协议
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AgreementController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * 协议类型
     */
    public function types()
    {
        $items = \App\Models\System\Dict::getOptions('AGREEMENT_TYPE');

        return response()->json($items);
    }

    /**
     * 协议列表
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = clamp($request->query('per_page', 15), 1, 100);
        $userId = $request->user()->id;
        $type = $request->query('type');
        $items = Agreement::active($type)
            ->with([
                'reads' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])
            ->orderByDesc('id')
            ->paginate($perPage);

        return AgreementResource::collection($items);
    }

    /**
     * 按类型获取协议
     *
     * @return AgreementResource
     */
    public function show($type)
    {
        $item = Agreement::active($type)
            ->orderBy('id', 'desc')
            ->firstOrFail();
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $item->markAsRead($user->id);
        }

        return new AgreementResource($item);
    }
}
