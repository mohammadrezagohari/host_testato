<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Resources\wallethistory\WalletHistoryResource;
use App\Repositories\MySQL\WalletHistoryRepository\InterfaceWalletHistoryRepository;
use Illuminate\Http\Request;
use Mockery\Exception;

/**
 * @group WalletHistory Section
 *
 * API endpoints for WalletHistory Services
 *
 * @subgroupDescription برای دسترسی به بخش های WalletHistory موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class WalletHistoryController extends Controller
{
    private InterfaceWalletHistoryRepository $interfaceWalletHistoryRepository;

    public function __construct(InterfaceWalletHistoryRepository $interfaceWalletHistoryRepository)
    {
        $this->interfaceWalletHistoryRepository = $interfaceWalletHistoryRepository;
    }

    public function index(Request $request)
    {
        try {
            $count = @$request->count ?? 10;
            return WalletHistoryResource::collection($this->interfaceWalletHistoryRepository->pagination($count));
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    public function me(Request $request)
    {
        try {
            $walletId = \Auth::user()->Wallet->id;
            $count = @$request->count ?? 10;
            return WalletHistoryResource::collection($this->interfaceWalletHistoryRepository->query()->where('wallet_id', '=', $walletId)->paginate($count));
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }
    }

    public function buy(Request $request)
    {
        try {
            $walletId = \Auth::user()->Wallet->id;
            $count = @$request->count ?? 10;
            $collection = $this->interfaceWalletHistoryRepository->query()->where('wallet_id', '=', $walletId)->where('type', '=', TransactionType::Buy)->paginate($count);
            return WalletHistoryResource::collection($collection);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }
    }

    public function pay(Request $request)
    {
        try {
            $walletId = \Auth::user()->Wallet->id;
            $count = @$request->count ?? 10;
            return WalletHistoryResource::collection($this->interfaceWalletHistoryRepository->query()->where('wallet_id', '=', $walletId)->where('type', '=', TransactionType::Pay)->paginate($count));
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }
    }

}
