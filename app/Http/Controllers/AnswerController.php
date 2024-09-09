<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\answer\AnswerByQuestionRequest;
use App\Http\Requests\answer\AnswerListByQuestionRequest;
use App\Http\Requests\answer\AnswerRequest;
use App\Http\Resources\answer\AnswerResource;
use App\Http\Resources\city\CityResource;
use App\Http\Resources\province\ProvinceResource;
use App\Repositories\MySQL\AnswerRepository\InterfaceAnswerRepository;
use App\Repositories\MySQL\AnswerSheetRepository\InterfaceAnswerSheetRepository;
use App\Repositories\MySQL\ExamRepository\InterfaceExamRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Answer
 *
 * API endpoints for Answer Services
 *
 * @subgroupDescription برای دسترسی به بخش های Answer موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AnswerController extends Controller
{
    private InterfaceAnswerRepository $interfaceAnswerRepository;
    private InterfaceAnswerSheetRepository $interfaceAnswerSheetRepository;
    private InterfaceExamRepository $interfaceExamRepository;

    public function __construct(InterfaceAnswerRepository $interfaceAnswerRepository,
                                InterfaceAnswerSheetRepository $interfaceAnswerSheetRepository,
                                InterfaceExamRepository $interfaceExamRepository
    )
    {
        $this->interfaceAnswerRepository = $interfaceAnswerRepository;
        $this->interfaceAnswerSheetRepository = $interfaceAnswerSheetRepository;
        $this->interfaceExamRepository = $interfaceExamRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $answers = $this->interfaceAnswerRepository->query()->paginate($count);
        return AnswerResource::collection($answers);
    }

    public function find_by_question(AnswerByQuestionRequest $request)
    {
        $questionId = @$request->question_id;
        $answers = $this->interfaceAnswerRepository->query();
        if (@$request->question_id)
            $answers = $answers->whereQuestionId($questionId);

        $answers = $answers->first();
        return new AnswerResource($answers);
    }

    public function list_by_questions(AnswerListByQuestionRequest $request)
    {
        $questions = @$request->questions;
        $answers = $this->interfaceAnswerRepository->query();
        if (@$questions)
            $answers = $answers->whereInQuestion($questions);

        $answers = $answers->first();
        return new AnswerResource($answers);
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
    }

    /*******************
     * @param AnswerRequest $request
     * @return JsonResponse
     */
    public function store(AnswerRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        $data['user_id'] = \Auth::user()->id;
        $result = null;
        $data["level_id"] = $this->interfaceExamRepository->findById($request->exam_id)->level_id;
        $answerSheet = $this->interfaceAnswerSheetRepository->query()->where('question_id', '=', $request->question_id)->first();
        $data['correct_option'] = $answerSheet->correct_option;
        if (@$this->interfaceAnswerRepository->query()->where('exam_id', '=', $request->exam_id)->where('question_id', '=', $request->question_id)->count()) {
            $answer = $this->interfaceAnswerRepository->query()->where('exam_id', '=', $request->exam_id)->where('question_id', '=', $request->question_id)->first();
            $result = $this->interfaceAnswerRepository->updateItem($answer->id, $data);
        } else {
            $result = $this->interfaceAnswerRepository->insertData($data);
        }
        if (@$result)
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function show(int $id): AnswerResource
    {
        return AnswerResource::make($this->interfaceAnswerRepository->findById($id));
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


    public function update(int $id, AnswerRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceAnswerRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if ($this->interfaceAnswerRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
