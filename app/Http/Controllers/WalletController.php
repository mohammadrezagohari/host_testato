<?php

namespace App\Http\Controllers;

use App\Enums\CoinType;
use App\Enums\Roles;
use App\Enums\TransactionType;
use App\Enums\WalletHistoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\wallet\PreviewInvoiceRequest;
use App\Http\Requests\wallet\WalletActionRequest;
use App\Http\Requests\wallet\WalletRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\invoice\InvoiceResource;
use App\Http\Resources\wallet\WalletHistoryResource;
use App\Http\Resources\wallet\WalletResource;
use App\Models\BaseInfo;
use App\Models\Coin;
use App\Models\WalletHistory;
use App\Repositories\MySQL\CoinRepository\InterfaceCoinRepository;
use App\Repositories\MySQL\PackageCoinRepository\InterfacePackageCoinRepository;
use App\Repositories\MySQL\WalletRepository\InterfaceWalletRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Log;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Wallet Section
 *
 * API endpoints for Wallet Services
 *
 * @subgroupDescription برای دسترسی به بخش های wallet موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class WalletController extends Controller
{
    private InterfaceWalletRepository $interfaceWalletRepository;
    private InterfacePackageCoinRepository $interfacePackageCoinRepository;
    private InterfaceCoinRepository $interfaceCoinRepository;

    public function __construct(InterfaceWalletRepository      $interfaceWalletRepository,
                                InterfacePackageCoinRepository $interfacePackageCoinRepository,
                                InterfaceCoinRepository        $interfaceCoinRepository
    )
    {
        $this->interfaceWalletRepository = $interfaceWalletRepository;
        $this->interfacePackageCoinRepository = $interfacePackageCoinRepository;
        $this->interfaceCoinRepository = $interfaceCoinRepository;
    }

    public function index(Request $request): BaseCollection
    {
        $count = @$request->count ?? 10;
        $wallets = $this->interfaceWalletRepository->query()->withIndex()->paginate($count);
        return new BaseCollection($wallets);
    }


    public function histories(Request $request): AnonymousResourceCollection
    {
        $count = $request->count ?? 10;
        $user = Auth::user();
        return WalletHistoryResource::collection(
            $user->Wallet->WalletHistories()->paginate($count)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /***************
     * Store a newly created resource in storage.
     * @param WalletRequest $request
     * @return JsonResponse
     */
    public function store(WalletRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = [
            'bonus' => $request->bonus,
            'amount' => $request->amount,
            'user_id' => $user->id,
        ];
        if ($this->interfaceWalletRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return WalletResource
     */
    public function show(int $id): WalletResource
    {
        return WalletResource::make($this->interfaceWalletRepository->findById($id));
    }

    /***********************
     * @return WalletResource
     */
    public function balance(): WalletResource
    {
        $user = Auth::user();
        return WalletResource::make($this->interfaceWalletRepository->query()->where('user_id', '=', $user->id)->first())->additional(
            [
                'description' => BaseInfo::where('key', '=', 'description_wallet')->first()->value
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit(int $id)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param WalletRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, WalletRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = [
            'bonus' => $request->bonus,
            'amount' => $request->amount,
            'user_id' => $user->id,
        ];
        if (@$user->hasRole(Roles::SuperLevel) && @$request->user_id) {
            $data['user_id'] = $request->user_id;
        }
        if ($this->interfaceWalletRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceWalletRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function increase_amount(WalletActionRequest $request)
    {
        try {
            $user = Auth::user();
            $wallet = $user->Wallet;
            $packageCoin = $this->interfacePackageCoinRepository->findById($request->package_coin_id);
            $valueGoldCoin = $this->interfaceCoinRepository->findByName(CoinType::Gold);
            $amountPrice = $packageCoin->quantity * $valueGoldCoin->value;
            $amount = $wallet->amount ? $packageCoin->quantity + $wallet->amount : $packageCoin->quantity;
            $user->Wallet()->update([
                'amount' => $amount,
            ]);
            $user->Wallet->WalletHistories()->create([
                'amount' => $packageCoin->quantity,
                'bonus' => 0,
                'type' => TransactionType::Buy,
                'base_price_coin' => $amountPrice,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'عملیات موفقیت آمیز بود',
                'amount' => $amount,
                'bonus' => $wallet->bonus
            ], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'متاسفانه! خطایی رخ داد'
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function increase_bonus(Request $request)
    {
        try {
            $user = Auth::user();
            $amount = $user->Wallet->bonus;
            $user->Wallet()->update(['bonus' => $amount]);
            return response()->json([
                'message' => 'عملیات موفقیت آمیز بود',
                'bonus' => $amount
            ], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function decrease_amount(WalletActionRequest $request)
    {
        try {
            $user = Auth::user();
            $currentAmount = $user->Wallet->amount;
            if ($currentAmount >= $request->value) {
                $amount = $currentAmount - $request->value;
                $user->Wallet()->update(['amount' => $amount]);
                return response()->json([
                    'message' => 'عملیات موفقیت آمیز بود',
                    'amount' => $amount
                ], HTTPResponse::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'sorry, your request grater to you wallet!',
                    'status' => false
                ], HTTPResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function decrease_bonus(WalletActionRequest $request)
    {
        try {
            $user = Auth::user();
            $currentAmount = $user->Wallet->bonus;
            if ($currentAmount >= $request->value) {
                $value = $currentAmount - $request->value;
                $user->Wallet()->update(['amount' => $value]);
                return response()->json([
                    'message' => 'عملیات موفقیت آمیز بود',
                    'bonus' => $value
                ], HTTPResponse::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'sorry, your request grater to you wallet!',
                    'status' => false
                ], HTTPResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function preview_invoice(PreviewInvoiceRequest $request)
    {
        try {
            $user = Auth::user();
            $questionQuantity = $request->question_quantity;
            $baseInfo_cost_per_question_gold = BaseInfo::whereHasKey(\App\Enums\BaseInfo::CostPerQuestionGold)->first(); /// قیمت سکه طلایی
            $baseInfo_cost_per_question_silver = BaseInfo::whereHasKey(\App\Enums\BaseInfo::CostPerQuestionGold)->first();  // قیمت سکه نقره ای
            $wallet = $this->interfaceWalletRepository->query()->withIndex()->whereUserId($user->id)->first();
            $sum = ($wallet->amount / $baseInfo_cost_per_question_gold->value) +
                ($wallet->bonus / $baseInfo_cost_per_question_silver->value);

            if ($sum < $questionQuantity) {
                return response()->json([
                    'message' => 'sorry_your_wallet_need_to_increase',
                    'has_credit' => false,
                ], HTTPResponse::HTTP_OK);
            }
            $coin_sliver = Coin::whereCoinName('silver')->first();
            $coin_gold = Coin::whereCoinName('gold')->first();
            $amountExam = $request->question_quantity * $baseInfo_cost_per_question_gold->value;
            return InvoiceResource::make($wallet)
                ->additional(
                    [
                        'amount_exam' => $amountExam,
                        'coin_gold' => $coin_gold->coin_amount, /// ضریب سکه طلایی
                        'coin_silver' => $coin_sliver->coin_amount,  /// ضریب سکه نقره ای
                        'description' => BaseInfo::where('key', '=', 'description_wallet')->first()->value
                    ]);

        } catch (Exception $exception) {
            Log::error($exception->getLine(), ['error', $exception->getMessage(), $exception->getCode()]);
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function insert($data)
    {
        return $this->interfaceWalletRepository->insertData($data);
    }

}
