<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\answer\AnswerByQuestionRequest;
use App\Http\Requests\answer\AnswerListByQuestionRequest;
use App\Http\Requests\answersheet\AnswerSheetListRequest;
use App\Http\Requests\answersheet\AnswerSheetRequest;
use App\Http\Resources\answersheet\AnswerSheetResource;
use App\Models\Answer;
use App\Repositories\MySQL\AnswerRepository\InterfaceAnswerRepository;
use App\Repositories\MySQL\AnswerSheetRepository\InterfaceAnswerSheetRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group AnswerSheet Section
 *
 * API endpoints for AnswerSheet
 *
 * @subgroupDescription برای دسترسی به بخش های AnswerSheet موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AnswerSheetController extends Controller
{
    private InterfaceAnswerSheetRepository $interfaceAnswerSheetRepository;
    private InterfaceAnswerRepository $interfaceAnswerRepository;

    public function __construct(InterfaceAnswerSheetRepository $interfaceAnswerSheetRepository, InterfaceAnswerRepository $interfaceAnswerRepository)
    {
        $this->interfaceAnswerSheetRepository = $interfaceAnswerSheetRepository;
        $this->interfaceAnswerRepository = $interfaceAnswerRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $answers = $this->interfaceAnswerSheetRepository->query()->paginate($count);
        return AnswerSheetResource::collection($answers);
    }

    public function list_by_exam(AnswerSheetListRequest $request)//: AnonymousResourceCollection
    {
        //// 3 question has 1 correct answers and 2 are wrong, but we see two answer are correct and on is wrong...
        $examId = @$request->exam_id;
        $answers = $this->interfaceAnswerRepository->query()->whereExamId($examId);
        $answerSheets = $this->interfaceAnswerSheetRepository->query()->withIndex();
        $answerSheets = $answerSheets->whereInQuestion($answers->pluck('question_id'));
        $result = $answerSheets->get();
        $answerItems = $answers->pluck('option_question_id');
        $collection = collect($answerSheets->pluck('options_question_id'));
        $userAnswers = collect($answerItems);
        $correctAnswersCount = $collection->where(function ($value, $key) use ($userAnswers) {
            return $value === $userAnswers[$key];
        })->count();
//        $correctAnswersCount = $answerSheets->whereIn('options_question_id', $answers->pluck('option_question_id'))->get();
        $incorrectAnswersCont = $answerSheets->count() - $correctAnswersCount;
        return AnswerSheetResource::collection($result)
            ->additional([
                'exam_id' => $examId,
//                'user_answer' => $answers->pluck('option_question_id'),
                'correct_answers_count' => $correctAnswersCount,  /// 2 ! 1
                'incorrect_answers_count' => $incorrectAnswersCont,  /// 0 ! 2
            ]);
    }


    public function get_quantity_answers($examId)
    {

    }


    /****
     * @param AnswerByQuestionRequest $request
     * @return AnswerSheetResource
     */
    public function find_by_question(AnswerByQuestionRequest $request): AnswerSheetResource
    {
        $questionId = @$request->question_id;
        $answers = $this->interfaceAnswerSheetRepository->query();
        if (@$request->question_id)
            $answers = $answers->whereQuestionId($questionId);

        $answers = $answers->first();
        return new AnswerSheetResource($answers);
    }

    /***************
     * @param AnswerListByQuestionRequest $request
     * @return AnswerSheetResource
     */
    public function list_by_questions(AnswerListByQuestionRequest $request): AnswerSheetResource
    {
        $questions = @$request->questions;
        $answers = $this->interfaceAnswerSheetRepository->query();
        if (@$questions)
            $answers = $answers->whereInQuestion($questions);

        $answers = $answers->first();
        return new AnswerSheetResource($answers);
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
    }

    /*******************
     * @param AnswerSheetRequest $request
     * @return JsonResponse
     */
    public function store(AnswerSheetRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if (@$request->video_link) {
            $data["video_link"] = upload_ads_video($request->video_link);
        }
        if (@$this->interfaceAnswerSheetRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function show(int $id): AnswerSheetResource
    {
        return AnswerSheetResource::make($this->interfaceAnswerSheetRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(int $id, AnswerSheetRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceAnswerSheetRepository->updateItem($id, $data))
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
        if ($this->interfaceAnswerSheetRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }


}
