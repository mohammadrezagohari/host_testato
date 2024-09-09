<?php

namespace App\Http\Controllers;

use App\Enums\BaseInfo;
use App\Enums\ExamType;
use App\Enums\Roles;
use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\exam\ExamHistoryRequest;
use App\Http\Requests\exam\ExamMonthRequest;
use App\Http\Requests\exam\ExamRequest;
use App\Http\Requests\exam\ExamShowDetailsQuestionRequest;
use App\Http\Requests\exam\ExamStudentRequest;
use App\Http\Requests\exam\ListOfUserExamRequest;
use App\Http\Requests\slider\SliderRequest;
use App\Http\Resources\answer\AnswerResource;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\exam\ExamHistoryResource;
use App\Http\Resources\exam\ExamMonthMeResource;
use App\Http\Resources\exam\ExamResource;
use App\Http\Resources\exam\ExamWithQuestionAndAnswersResource;
use App\Http\Resources\question\QuestionResource;
use App\Http\Resources\slider\SliderResource;
use App\Infrastructure\Wallet;
use App\Repositories\MySQL\BaseInfoRepository\InterfaceBaseInfoRepository;
use App\Repositories\MySQL\CourseRepository\InterfaceCourseRepository;
use App\Repositories\MySQL\ExamRepository\InterfaceExamRepository;
use App\Repositories\MySQL\QuestionRepository\InterfaceQuestionRepository;
use App\Repositories\MySQL\WalletHistoryRepository\InterfaceWalletHistoryRepository;
use App\Repositories\MySQL\WalletRepository\InterfaceWalletRepository;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Log;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Exams
 *
 * API endpoints for Exams
 *
 * @subgroupDescription برای دسترسی به بخش های Exams موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class ExamController extends Controller
{
    private InterfaceExamRepository $interfaceExamRepository;
    private InterfaceWalletRepository $interfaceWalletRepository;
    private InterfaceWalletHistoryRepository $interfaceWalletHistoryRepository;
    private InterfaceBaseInfoRepository $interfaceBaseInfoRepository;
    private InterfaceCourseRepository $interfaceCourseRepository;
    private InterfaceQuestionRepository $interfaceQuestionRepository;

    public function __construct(
        InterfaceExamRepository          $interfaceExamRepository,
        InterfaceWalletRepository        $interfaceWalletRepository,
        InterfaceWalletHistoryRepository $interfaceWalletHistoryRepository,
        InterfaceBaseInfoRepository      $interfaceBaseInfoRepository,
        InterfaceCourseRepository        $interfaceCourseRepository,
        InterfaceQuestionRepository      $interfaceQuestionRepository
    )
    {
        $this->interfaceExamRepository = $interfaceExamRepository;
        $this->interfaceWalletRepository = $interfaceWalletRepository;
        $this->interfaceWalletHistoryRepository = $interfaceWalletHistoryRepository;
        $this->interfaceBaseInfoRepository = $interfaceBaseInfoRepository;
        $this->interfaceCourseRepository = $interfaceCourseRepository;
        $this->interfaceQuestionRepository = $interfaceQuestionRepository;
    }

    public function index(Request $request): BaseCollection
    {
        $count = @$request->count ?? 10;
        $grades = $this->interfaceExamRepository->query()->withIndex()->paginate($count);
        return new BaseCollection($grades);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }


    public function student_store(ExamStudentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $course = $this->interfaceCourseRepository->findById($request->course_id);
            $examName = $this->interfaceExamRepository->SetExamName($course->id, $user->id);
            $data = [
                'question_quantity' => $request->question_quantity,
                'answer_quantity' => 0,
                'time_exam' => 0,
                'score' => 0,
                'status' => ExamType::created,
                'user_id' => $user->id,
                'level_id' => $request->level_id,
                'course_id' => $request->course_id,
                'name' => $examName,
            ];
            $this->interfaceWalletRepository->decrease_value_for_payment($user->Wallet, $request->silver_coin, $request->gold_coin);

            $baseInfo = $this->interfaceBaseInfoRepository->findFirstSection(BaseInfo::CostCoinsPart, BaseInfo::CostPerQuestionGold);
            $this->interfaceWalletHistoryRepository->insertData([
                'wallet_id' => $user->Wallet->id,
                'amount' => $request->gold_coin,
                'bonus' => $request->silver_coin,
                'type' => TransactionType::Pay,
                'base_price_coin' => $baseInfo->value,
            ]);
            $result = $this->interfaceExamRepository->insertData($data);
            if (@$result) {
                DB::commit();
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'data' => $result], HTTPResponse::HTTP_OK);
            }
            DB::rollBack();
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            Log::error($exception->getLine(), [$exception->getMessage(), $exception->getCode()]);
            DB::rollBack();
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد, please contact your administrator.'], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    /********************************************
     * Store a newly created resource in storage.
     * @param ExamRequest $request
     * @return JsonResponse
     ********************************************/
    public function store(ExamRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = [
            'question_quantity' => $request->question_quantity,
            'answer_quantity' => 0,
            'time_exam' => 90,
            'status' => ExamType::created,
            'user_id' => $user->id,
            'level_id' => $request->level_id,
            'course_id' => $request->course_id,
        ];
        if ($this->interfaceExamRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     */
    public function show(int $id)//: ExamWithQuestionAndAnswersResource
    {
        $user = Auth::user();
        if (!$this->interfaceExamRepository->findById($id)) {
            return response()->json(['message' => 'sorry, Exam with your request not exit', 'status' => false], HTTPResponse::HTTP_FORBIDDEN);
        }
//        if (@$user->hasRole(Roles::SuperLevel)) {
//            $exams = $this->interfaceExamRepository->query()->withIndexAndAnswers()->where('user_id','=',$user->id)->find($id);
//            return ExamWithQuestionAndAnswersResource::make($exams);
//        }
        $exam = $this->interfaceExamRepository->query()->withIndexAndAnswers()->where('id', '=', $id)->first();//->withIndexAndAnswers()->where('user_id', '=', $user->id)->first();
        return ExamWithQuestionAndAnswersResource::make($exam);
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
     * @param ExamRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, ExamRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = [
            'question_quantity' => $request->question_quantity,
            'answer_quantity' => $request->answer_quantity,
            'time_exam' => 90,
            'status' => $request->status,
            'user_id' => $user->id,
            'level_id' => $request->level_id,
            'course_id' => $request->course_id,
            'score' => $request->score,
        ];
        if ($this->interfaceExamRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function finish_exam($examId): JsonResponse
    {
        $currentExam = $this->interfaceExamRepository->findById($examId);
        $user = Auth::user();
        if ($currentExam->user_id != $user->id && !$user->hasRole(Roles::SuperLevel))
            return response()->json(['message' => "sorry, you can't access to other people exam"], HTTPResponse::HTTP_BAD_REQUEST);
        $currentExam->status = ExamType::done;
        if ($currentExam->save())
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'exam_id' => $currentExam->id], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function list_of_user_exams(ListOfUserExamRequest $request): JsonResponse
    {
        $count = @$request->count ?? 10;
        $user = $request->user_id;
        $exams = $this->interfaceExamRepository->query()
            ->whereUser($user->id)
            ->withIndex()
            ->paginate($count);
        return response()->json($exams);
    }

    public function list_of_my_exams(Request $request): JsonResponse
    {
        $count = @$request->count ?? 10;
        $user = Auth::user();
        $exams = $this->interfaceExamRepository->query()
            ->whereUser($user->id)
            ->withIndex()
            ->paginate($count);
        return response()->json($exams);
    }

    /****************************
     * last month exams for current user
     * @param ExamMonthRequest $request
     * @return AnonymousResourceCollection
     */
    public function last_month_me(ExamMonthRequest $request)
    {
        $user = Auth::user();
        $startDate = $request->start_at;//Carbon::now()->subMonth();
        $endDate = $request->end_at;//Carbon::now();
        $exams = $this->interfaceExamRepository->query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereUser($user->id)
            ->withIndex()
            ->get();
        return ExamMonthMeResource::collection($exams);
    }


    public function find_specific_course_exam($course_id, Request $request): JsonResponse
    {
        $count = @$request->count ?? 10;
        $user = Auth::user();
        $result = $this->interfaceExamRepository->query()
            ->whereUser($user->id)->whereCourse($course_id)
            ->withIndex()->paginate($count);
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceExamRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    ///// جهت ادامه به آزمون
    public function status(): JsonResponse
    {
        $user = Auth::user();
        $result = $user->Exams()->whereStatusUnfinished()->orderByDesc('id')->first();
        return response()->json(['current_exam' => $result]);
    }


    public function history(ExamHistoryRequest $request)
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword ?? null;
        $dateStart = @$request->date_start ?? null;
        $dateEnd = @$request->date_end ?? null;
        $user = Auth::user();
        if ($user->hasRole(Roles::SuperLevel)) {
            $query = $this->interfaceExamRepository->query()
                ->withIndex();
        } else {
            $query = $this->interfaceExamRepository->query()
                ->whereUser($user->id)
                ->withIndex();
        }
        if (@$keyword) {
            $query = $query->whereKeywordIs($keyword);
        }
        if (@$dateStart && @$dateEnd)
            $query = $query->whereKeyword($keyword, $dateStart, $dateEnd);

        return ExamHistoryResource::collection($query->orderByDesc('id')->paginate($count));
    }


    public function show_details_question(ExamShowDetailsQuestionRequest $request)
    {
        $answer = null;
        if (@$request->exam_id) {
            $exam = $this->interfaceExamRepository->query()->withIndexAndAnswers()->find($request->exam_id);
            $answer = $exam->Answers()->where('question_id', '=', $request->question_id)->first();
        }
        $question = $this->interfaceQuestionRepository->query()->with(['QuestionAttachments'])->where('id', '=', $request->question_id)->first();

        return response()->json(['answer' =>
            @$answer ? AnswerResource::make($answer) : null, 'question' => QuestionResource::make($question)]);
    }

    public function Statistic()
    {
        return $this->interfaceExamRepository->quantity();
    }
}
