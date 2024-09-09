<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\contact\ContactRequest;
use App\Http\Resources\contact\ContactResource;
use App\Repositories\MySQL\ContactRepository\InterfaceContactRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Contact
 *
 * API endpoints for Contact
 *
 * @subgroupDescription برای دسترسی به بخش های Contact موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class ContactController extends Controller
{
    private InterfaceContactRepository $interfaceContactRepository;

    public function __construct(InterfaceContactRepository $interfaceContactRepository)
    {
        $this->interfaceContactRepository = $interfaceContactRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $cities = $this->interfaceContactRepository->pagination($count);
        return ContactResource::collection($cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
    }

    /***************
     * @param ContactRequest $request
     * @return JsonResponse
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        $item = $this->interfaceContactRepository->first();
        if (@$item) {
            $this->interfaceContactRepository->updateItem($item->id, $data);
        }
        if ($this->interfaceContactRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return ContactResource
     */
    public function show(int $id): ContactResource
    {
        return ContactResource::make($this->interfaceContactRepository->findById($id));
    }
    /**************************
     * @return ContactResource
     */
    public function latest(): ContactResource
    {
        return ContactResource::make($this->interfaceContactRepository->query()->latest()->first());
    }


}
