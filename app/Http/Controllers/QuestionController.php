<?php

namespace App\Http\Controllers;

use App\Enums\AttachmentType;
use App\Enums\QuestionFileType;
use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\question\QuestionExamCreateRequest;
use App\Http\Requests\question\QuestionListRequest;
use App\Http\Requests\question\QuestionRequest;
use App\Http\Requests\question\VideosCollectionRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\question\QuestionListResource;
use App\Http\Resources\question\QuestionResource;
use App\Models\Exam;
use App\Repositories\MySQL\AnswerSheetRepository\InterfaceAnswerSheetRepository;
use App\Repositories\MySQL\LevelRepository\InterfaceLevelRepository;
use App\Repositories\MySQL\QuestionAttachmentRepository\InterfaceQuestionAttachmentRepository;
use App\Repositories\MySQL\QuestionRepository\InterfaceQuestionRepository;
use App\Repositories\MySQL\UnitRepository\InterfaceUnitRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Question
 *
 * API endpoints for Question Services
 *
 * @subgroupDescription برای دسترسی به بخش های Question موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class QuestionController extends Controller
{
    private InterfaceQuestionRepository $interfaceQuestionRepository;
    private InterfaceUnitRepository $interfaceUnitRepository;
    private InterfaceLevelRepository $interfaceLevelRepository;
    private InterfaceAnswerSheetRepository $interfaceAnswerSheetRepository;
    private InterfaceQuestionAttachmentRepository $interfaceQuestionAttachmentRepository;

    public function __construct(InterfaceQuestionRepository           $interfaceQuestionRepository,
                                InterfaceUnitRepository               $interfaceUnitRepository,
                                InterfaceLevelRepository              $interfaceLevelRepository,
                                InterfaceAnswerSheetRepository        $interfaceAnswerSheetRepository,
                                InterfaceQuestionAttachmentRepository $interfaceQuestionAttachmentRepository
    )
    {
        $this->interfaceQuestionRepository = $interfaceQuestionRepository;
        $this->interfaceUnitRepository = $interfaceUnitRepository;
        $this->interfaceLevelRepository = $interfaceLevelRepository;
        $this->interfaceAnswerSheetRepository = $interfaceAnswerSheetRepository;
        $this->interfaceQuestionAttachmentRepository = $interfaceQuestionAttachmentRepository;
    }

    public function index(Request $request)
    {
        try {
            $count = @$request->count ?? 10;
            $result = $this->interfaceQuestionRepository->query()->withIndex()->orderByDesc("id")->paginate($count);
            return QuestionListResource::collection($result);
        } catch (\Exception $exception) {
            \Log::debug('error question:index = ' . $exception->getLine(), $exception->getMessage());
            return response()->json(['error' => $exception->getMessage(), 'line' => $exception->getLine()], $exception->getCode());
        }

    }

    public function list(QuestionExamCreateRequest $request): AnonymousResourceCollection
    {
        $exam = Exam::find($request->exam_id);
        $user = Auth::user();
        $result = $this->interfaceQuestionRepository->query()->withIndex()
            ->whereLevelId($exam->level_id)
            ->limit($exam->question_quantity)
            ->get();
//        return QuestionListResource::collection($result);
        return QuestionListResource::collection($result)->additional([
            'coin_amount' => $user->Wallet->amount ?? null
        ]);
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
     * @param QuestionRequest $request
     * @return JsonResponse
     */
    public function store(QuestionRequest $request): JsonResponse
    {
        DB::beginTransaction();
        $request->questions_type = QuestionType::select;
        $fileUrl = null;
        $image = $request->file('image');
        if (@$image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $fileUrl = env('app_url') . '/images/unit/' . $imageName;
        }
        $data = [
            'title' => $request->title,
            'course_id' => $request->course,
            'grade_id' => $request->grade,
            'level_id' => $request->level,
            'unit_id' => $request->unit,
            'section_id' => $request->section,
            'teacher_id' => Auth::user()->id,
        ];
        $newItem = $this->interfaceQuestionRepository->insertData($data);
        $level = $this->interfaceLevelRepository->findById($data['level_id']);
        $level->quantity_questions = $level->Questions()->count();
        $level->save();
        if (@$newItem) {
            if (@$fileUrl) {
                $newItem->QuestionAttachments()->create([
                    'file_url' => $fileUrl,
                    'is_current' => true,
                    'type' => QuestionFileType::Image,
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        }
        DB::rollBack();
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***************
     * Store a newly created resource in storage.
     * @param QuestionRequest $request
     * @return JsonResponse
     */
    public function store_video_step(Request $request, $question_id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $question = $this->interfaceQuestionRepository->findById($question_id);
            if (@$request->hasFile("video")) {
                $file = $request->file("video");
                if (!@$question->QuestionAttachments()->where('question_id', '=', $question_id)->where('type', '=', QuestionFileType::Video)->count()) {
                    $filePath = upload_question_video($file);
                    $question->QuestionAttachments()->create([
                        'file_url' => $filePath,
                        'is_current' => true,
                        'type' => QuestionFileType::Video
                    ]);
                } else {
//                    return response()->json(["ddta"=>$question->QuestionAttachments()->where('type', '=', QuestionFileType::Video)->get() ],501);
                    foreach ($question->QuestionAttachments()->where('type', '=', QuestionFileType::Video)->get() as $attachment) {
                        $attachment->is_current = false;
                        if (@$attachment->file_url)
                            delete_data_upload($attachment->file_url);
                        $attachment->save();
//                        return response()->json(["data"=>$attachment],501);
                    }

                    $filePath = upload_question_video($file);
                    $question->QuestionAttachments()->create([
                        'file_url' => $filePath,
                        'is_current' => true,
                        'type' => QuestionFileType::Video
                    ]);
                }

            }

            DB::commit();
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage(), 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        }


    }
//
//    /********************
//     * @param VideosCollectionRequest $request
//     * @return JsonResponse
//     * @throws \Throwable
//     */
//    public function store_videos_collection_step(VideosCollectionRequest $request): JsonResponse
//    {
//        try {
//            DB::beginTransaction();
//            $videos = $request->file("videos");
//            $questions = $request->questions;
//            foreach ($videos as $key => $file) {
//                $question = $this->interfaceQuestionAttachmentRepository->findById($questions[$key]);
//                if (@$file) {
//                    $filePath = upload_question_video($file);
//                    $question->QuestionAttachments()->create([
//                        'file_url' => $filePath,
//                        'is_current' => true,
//                        'type' => QuestionFileType::Video
//                    ]);
//                }
//            }
//            DB::commit();
//            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
//        } catch (Exception $exception) {
//            DB::rollBack();
//            return response()->json(['message' => $exception->getMessage(), 'line' => $exception->getLine(), 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
//        }
//
//
//    }

    public function store_collection(Request $request): JsonResponse
    {
        try {
            $data = [
                'level_id' => $request->level,
                'course_id' => $request->course,
                'unit_id' => $request->units,
                'section_id' => $request->section,
                'grade_id' => $request->grade,
                'teacher_id' => Auth::user()->id,
                'question_type' => QuestionType::select,
            ];
            $unit = $this->interfaceUnitRepository->findById($data['unit_id']);
            $level = $this->interfaceLevelRepository->findById($data['level_id']);
            DB::beginTransaction();
            $data['title'] = question_name_generator($unit, $level);
            $questions = [];
            foreach ($request->file("image") as $key => $file) {
                if (@$file) {
                    ////TODO:DO Fix Problem On server Important
                    $chooseItemAnswer = find_and_get_string($file->getClientOriginalName(), "#");
                    $filePath = upload_question_image($file);
                    $question = $this->interfaceQuestionRepository->insertReturnNewInstance($data, $filePath);
                    $questions[$key] = $question->id;
                    $this->interfaceAnswerSheetRepository->insertData([
                        'question_id' => $question->id,
                        'options_question_id' => intval($chooseItemAnswer),
                    ]);
//                    $videos = $request->file("video");
//                    $fileNameObj = $videos[$key]->getFilename();
//                    $filePathObj = upload_question_video($fileNameObj);
//                    $this->interfaceQuestionAttachmentRepository->insertData([
//                        'question_id' => $question->id,
//                        'file_url' => $filePathObj,
//                        'is_current' => true,
//                        'type' => QuestionFileType::Video,
//                    ]);
                }
            }
            $level->quantity_questions = $level->Questions()->count();
            $level->save();
            DB::commit();
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true, 'list' => $questions], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage(), [$exception->getLine(), $exception->getCode()]);
            return response()->json(["fails" => 'متاسفانه! خطایی رخ داد']);
        }

    }

    /***********************
     * @param int $id
     * @return QuestionResource
     */
    public
    function show(int $id): QuestionResource
    {
        return QuestionResource::make($this->interfaceQuestionRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public
    function edit(int $id)
    {
    }

    /********
     * @param int $id
     * @param QuestionRequest $request
     * @return JsonResponse|void
     */
    public function update(int $id, QuestionRequest $request)
    {
        try {
            $fileImage = null;
            $fileVideo = null;

            if (@$request->hasFile("image")) {
                $fileImage = upload_question_image($request->file('image'));
            }
            if (@$request->hasFile("video")) {
                $fileVideo = upload_question_video($request->file('video'));
            }
            $data = [
                'title' => $request->title,
                'course_id' => $request->course_id,
                'grade_id' => $request->grade_id,
            ];
            $item = $this->interfaceQuestionRepository->updateItem($id, $data);
            if (@$item) {
                if (@$fileImage) {
                    if (@$item->QuestionAttachments()->where("type", '=', AttachmentType::IMAGE)->where('is_current', '=', true)->count()) {
                        foreach ($item->QuestionAttachments()->where("type", '=', AttachmentType::IMAGE)->get() as $image) {
                            delete_data_upload($image->file_url);
                            $image->is_current = false;
                            $image->save();
                        }
                    }
                    $item->UnitAttachments()->create([
                        'image_url' => $fileImage,
                        'type' => AttachmentType::IMAGE,
                        'current' => AttachmentType::IMAGE,
                    ]);
                }
            }

            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'status' => false], $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $images = $this->interfaceQuestionRepository->getAttachments($id);
            foreach ($images as $image) {
                if (@$image->file_url)
                    delete_data_upload($image->file_url);
                $this->interfaceQuestionAttachmentRepository->deleteData($image->id);
            }
            if ($this->interfaceQuestionRepository->deleteData($id))
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage(), "status" => false], $exception->getCode());
        }

    }


    public function show_details_question_without_answer($id)
    {
        $question = $this->interfaceQuestionRepository->query()->with(['QuestionAttachments'])->where('id', '=', $id)->first();
        return response()->json(['answer_sheet' => $question->AnswerSheet, 'question' => $question]);
    }


    public function Statistic()
    {
        return $this->interfaceQuestionRepository->quantity();
    }

}
