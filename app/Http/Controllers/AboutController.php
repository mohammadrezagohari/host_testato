<?php

namespace App\Http\Controllers;

use App\Enums\BaseInfo;
use App\Http\Controllers\Controller;
use App\Http\Requests\about\AboutRequest;
use App\Http\Resources\about\AboutResource;
use App\Repositories\MySQL\BaseInfoRepository\InterfaceBaseInfoRepository;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Log;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group About
 * API endpoints for About
 * @subgroupDescription برای دسترسی به بخش های About موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AboutController extends Controller
{
    private InterfaceBaseInfoRepository $interfaceBaseInfoRepository;

    public function __construct(InterfaceBaseInfoRepository $interfaceBaseInfoRepository)
    {
        $this->interfaceBaseInfoRepository = $interfaceBaseInfoRepository;
    }

    public function index(Request $request)
    {
        $aboutPart = $this->interfaceBaseInfoRepository->getSection(BaseInfo::AboutPart);
        $about = [];

        foreach ($aboutPart as $item) {
            if ($item->key == "title") {
                $about["title"] = $item->value;
            }
            if ($item->key == "context") {
                $about["context"] = $item->value;
            }
        }
        return AboutResource::make($about);
    }


    public function store(AboutRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $about_title = $this->interfaceBaseInfoRepository->findFirstSection(BaseInfo::AboutPart, "title");
            $about_context = $this->interfaceBaseInfoRepository->findFirstSection(BaseInfo::AboutPart, "context");
            if (@$about_title && $about_context) {
                $about_title->key = "title";
                $about_title->value = $request->title;
                $about_title->save();
                $about_context->key = "context";
                $about_context->value = $request->context;
                $about_context->save();
                DB::commit();
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            } else {
                $this->interfaceBaseInfoRepository->insertData([
                    'key' => 'title',
                    'value' => $request->title,
                    'section' => BaseInfo::AboutPart
                ]);
                $this->interfaceBaseInfoRepository->insertData([
                    'key' => 'context',
                    'value' => $request->context,
                    'section' => BaseInfo::AboutPart
                ]);
                DB::commit();
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            }
            DB::rollBack();
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('about_error', ["message" => $exception->getMessage(), "line" => $exception->getLine()]);
            return response()->json(["message" => $exception->getMessage(), "line" => $exception->getLine()]);

        }
    }

}
