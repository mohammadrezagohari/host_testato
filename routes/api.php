<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AnswerSheetController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FamiliarController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PackageCoinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\SummaryFormulaController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitExerciseController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletHistoryController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('forget', [AuthController::class, 'forget_password']);
    Route::prefix('otp')->group(function () {
        Route::post('/', [AuthController::class, 'otp'])->name('otp');
        Route::post('/verify', [AuthController::class, 'verifyMobile']);
    });
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix' => 'level'], function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::post('/store', [LevelController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [LevelController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [LevelController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [LevelController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::get('/list-with-count', [CourseController::class, 'list_with_count']);
        Route::get('/', [CourseController::class, 'index']);
//        Route::get('/course-by-grade/{id}', [CourseController::class, 'course_by_grade']);
//        Route::post('/course-by-grade-field', [CourseController::class, 'course_by_grade_and_field']);
        Route::get('/list', [CourseController::class, 'list']);
        Route::post('/store', [CourseController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [CourseController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [CourseController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [CourseController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'field'], function () {
        Route::get('/', [FieldController::class, 'index']);
        Route::post('/store', [FieldController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [FieldController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [FieldController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [FieldController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'grade'], function () {
        Route::get('/', [GradeController::class, 'index']);
        Route::post('/store', [GradeController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [GradeController::class, 'show'])->middleware('is_admin');
//        Route::get('/grade_by_field/{id}', [GradeController::class, 'grade_by_field']);
        Route::post('/update/{id}', [GradeController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [GradeController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'school'], function () {
        Route::get('/', [SchoolController::class, 'index']);
        Route::post('/store', [SchoolController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [SchoolController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [SchoolController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [SchoolController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'section'], function () {
        Route::get('/', [SectionController::class, 'index']);
        Route::post('/list', [SectionController::class, 'list']);
        Route::post('/store', [SectionController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [SectionController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [SectionController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [SectionController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'unit'], function () {
        Route::get('/', [UnitController::class, 'index']);
        Route::post('/list', [UnitController::class, 'list']);
        Route::get('/units-by-course-grade/{courseId}/grade/{gradeId}', [UnitController::class, 'units_by_course_grade']);
        Route::get('/units-by-course/{id}', [UnitController::class, 'units_by_course']);
        Route::post('/store', [UnitController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [UnitController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [UnitController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'ads'], function () {
        Route::get('/', [AdvertisementController::class, 'index']);
        Route::post('/list', [AdvertisementController::class, 'list']);
        Route::get('/show/random', [AdvertisementController::class, 'show_random']);
        Route::post('/store', [AdvertisementController::class, 'store'])->middleware('is_admin');
        Route::delete('/delete/{id}', [AdvertisementController::class, 'destroy'])->middleware('is_admin');
    });
    Route::group(['prefix' => 'familiar'], function () {
        Route::get('/', [FamiliarController::class, 'index']);
        Route::get('/show/{id}', [FamiliarController::class, 'show'])->middleware('is_admin');
        Route::post('/store', [FamiliarController::class, 'store'])->middleware('is_admin');
        Route::post('/update/{id}', [FamiliarController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [FamiliarController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::get('/statistic', [ProfileController::class, 'Statistic']);
        Route::post('/store', [ProfileController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [ProfileController::class, 'show'])->middleware('is_admin');
        Route::get('/account/{id}', [ProfileController::class, 'account'])->middleware('is_admin');
        Route::get('/me', [ProfileController::class, 'me'])->name('me');
        Route::post('/account/update', [ProfileController::class, 'update_account']);
        Route::post('/update/{id}', [ProfileController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [ProfileController::class, 'destroy'])->middleware('is_admin');

        Route::post('/step_is_student', [ProfileController::class, 'step_is_student'])->name('step_is_student');
        Route::post('/step_field', [ProfileController::class, 'step_field'])->name('step_field');
        Route::post('/step_grade', [ProfileController::class, 'step_grade'])->name('step_grade');
        Route::post('/step_access_type', [ProfileController::class, 'step_access_type'])->name('step_access_type');
    });

    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', [SliderController::class, 'index']);
        Route::post('/store', [SliderController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [SliderController::class, 'show']);
        Route::post('/update/{id}', [SliderController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [SliderController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'story'], function () {
        Route::get('/', [StoryController::class, 'index']);
        Route::post('/store', [StoryController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [StoryController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [StoryController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [StoryController::class, 'destroy'])->middleware('is_admin');
        Route::get('/visited/{id}', [StoryController::class, 'visited']);
    });

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/', [WalletController::class, 'index'])->middleware('is_admin');
        Route::post('/store', [WalletController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [WalletController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [WalletController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [WalletController::class, 'destroy'])->middleware('is_admin');
        Route::get('/balance', [WalletController::class, 'balance'])->name('balance');
//        Route::post('/increase/pre-paid', [WalletController::class, 'increase_amount_pre_paid']);
        Route::post('/increase/amount', [WalletController::class, 'increase_amount']);
        Route::post('/decrease/amount', [WalletController::class, 'decrease_amount']);
        Route::post('/increase/bonus', [WalletController::class, 'increase_bonus']);
        Route::post('/decrease/bonus', [WalletController::class, 'decrease_bonus']);
        Route::post('/preview_invoice', [WalletController::class, 'preview_invoice']);
        Route::get('/histories', [WalletController::class, 'histories']);
    });


    Route::group(['prefix' => 'wallet-history'], function () {
        Route::get('/', [WalletHistoryController::class, 'index'])->middleware('is_admin');
        Route::get('/my-balance', [WalletHistoryController::class, 'me']);
        Route::get('/me/buy', [WalletHistoryController::class, 'buy']);
        Route::get('/me/pay', [WalletHistoryController::class, 'pay']);

    });

    Route::group(['prefix' => 'exam'], function () {
        Route::get('/statistic', [ExamController::class, 'Statistic']);
        Route::get('/', [ExamController::class, 'index'])->middleware('is_admin');
        Route::get('/status', [ExamController::class, 'status']);
        Route::get('/show/{id}', [ExamController::class, 'show']);
        Route::get('/finish-exam/{id}', [ExamController::class, 'finish_exam']);
        Route::post('/history', [ExamController::class, 'history']);
        Route::post('/show_details_question', [ExamController::class, 'show_details_question']);
        Route::get('/list/me', [ExamController::class, 'list_of_my_exams']);
        Route::post('/list/user', [ExamController::class, 'list_of_user_exams']);
        Route::get('/list/last_month_me', [ExamController::class, 'last_month_me']);
        Route::post('/student_store', [ExamController::class, 'student_store']);
        Route::get('/list/by/course/{course_id}', [ExamController::class, 'find_specific_course_exam']);
        Route::post('/store', [ExamController::class, 'store'])->middleware('is_admin');
        Route::post('/update/{id}', [ExamController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [ExamController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'province'], function () {
        Route::get('/', [ProvinceController::class, 'index']);
        Route::post('/store', [ProvinceController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [ProvinceController::class, 'show']);
        Route::post('/update/{id}', [ProvinceController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [ProvinceController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', [AlertController::class, 'index']);
        Route::get('/me', [AlertController::class, 'me']);
        Route::post('/store', [AlertController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [AlertController::class, 'show']);
        Route::post('/update/{id}', [AlertController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [AlertController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'city'], function () {
        Route::get('/', [CityController::class, 'index']);
        Route::post('/list_by_province', [CityController::class, 'list_by_province'])->name('list_by_province');
        Route::post('/store', [CityController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [CityController::class, 'show']);
        Route::post('/update/{id}', [CityController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [CityController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'address'], function () {
        Route::get('/get-address', [AddressController::class, 'geo_to_address'])->name('geo_to_address');
    });

    Route::group(['prefix' => 'version'], function () {
        Route::get('/statistic', [VersionController::class, 'Statistic']);

        Route::get('/latest', [VersionController::class, 'latest'])->name('latest');
        Route::get('/', [VersionController::class, 'index'])->middleware('is_admin');
        Route::post('/store', [VersionController::class, 'store'])->middleware('is_admin');
        Route::post('/store_version_file', [VersionController::class, 'store_version_file'])->middleware('is_admin');
        Route::get('/show/{id}', [VersionController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [VersionController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [VersionController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'summary'], function () {
        Route::get('/list', [SummaryFormulaController::class, 'list']);
        Route::get('/', [SummaryFormulaController::class, 'index'])->middleware('is_admin');
        Route::post('/store', [SummaryFormulaController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [SummaryFormulaController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [SummaryFormulaController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [SummaryFormulaController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'unit_exercise'], function () {
        Route::get('/list', [UnitExerciseController::class, 'list']);
        Route::get('/', [UnitExerciseController::class, 'index'])->middleware('is_admin');
        Route::post('/store', [UnitExerciseController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [UnitExerciseController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [UnitExerciseController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [UnitExerciseController::class, 'destroy'])->middleware('is_admin');
    });


    Route::group(['prefix' => 'question'], function () {
            Route::get('/statistic', [QuestionController::class, 'Statistic']);
        Route::get('/', [QuestionController::class, 'index'])->middleware('is_admin');
        Route::get('/list', [QuestionController::class, 'list']);
        Route::get('/show_details_question_without_answer/{id}', [QuestionController::class, 'show_details_question_without_answer']);
        Route::post('/store', [QuestionController::class, 'store'])->middleware('is_admin');
        Route::post('/store_video_step/{id}', [QuestionController::class, 'store_video_step'])->middleware('is_admin');
//        Route::post('/store_videos_collection_step', [QuestionController::class, 'store_videos_collection_step'])->middleware('is_admin');
        Route::post('/store_collection', [QuestionController::class, 'store_collection'])->name('store_collection')->middleware('is_admin');
        Route::get('/show/{id}', [QuestionController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [QuestionController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [QuestionController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/', [AttendanceController::class, 'index'])->middleware('is_admin');
        Route::get('/list_for_user', [AttendanceController::class, 'list_for_user'])->middleware('is_admin');
        Route::get('/list_for_me', [AttendanceController::class, 'list_for_me']);
    });

    Route::group(['prefix' => 'answer'], function () {
        Route::get('/list-by-question', [AnswerController::class, 'list_by_questions']);
        Route::post('/find-by-question', [AnswerController::class, 'find_by_question'])->name('find_by_question');
        Route::post('/store', [AnswerController::class, 'store']);
        Route::get('/', [AnswerController::class, 'index']);
        Route::get('/show/{id}', [AnswerController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [AnswerController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [AnswerController::class, 'destroy'])->middleware('is_admin');
    });
    Route::group(['prefix' => 'answer-sheet'], function () {
        Route::get('/list-by-exam', [AnswerSheetController::class, 'list_by_exam']);  /////TODO:DO it
        Route::get('/list-by-question', [AnswerSheetController::class, 'list_by_questions']);
        Route::post('/find-by-question', [AnswerSheetController::class, 'find_by_question']);
        Route::post('/store', [AnswerSheetController::class, 'store'])->middleware('is_admin');
        Route::get('/', [AnswerSheetController::class, 'index']);
        Route::get('/show/{id}', [AnswerSheetController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [AnswerSheetController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [AnswerSheetController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'bookmark'], function () {
        Route::get('/list-my-bookmark', [BookmarkController::class, 'list_my_bookmark'])->name('list_my_bookmark');
        Route::get('/', [BookmarkController::class, 'index'])->middleware('is_admin');
        Route::post('/change_category', [BookmarkController::class, 'change_category']);
        Route::delete('/delete_from_category/{id}', [BookmarkController::class, 'delete_from_category']);
        Route::post('/store', [BookmarkController::class, 'store']);
        Route::get('/show/{id}', [BookmarkController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [BookmarkController::class, 'update']);
        Route::delete('/delete/{id}', [BookmarkController::class, 'destroy']);
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->middleware('is_admin');
        Route::get('/list', [CategoryController::class, 'list'])->middleware('is_admin');
        Route::get('/list-user', [CategoryController::class, 'list_user'])->name('list_user');
        Route::post('/store', [CategoryController::class, 'store']);
//        Route::get('/show/{id}', [CategoryController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'suggestion'], function () {
        Route::get('/', [SuggestionController::class, 'index'])->middleware('is_admin');
        Route::post('/store', [SuggestionController::class, 'store']);
        Route::get('/show/{id}', [SuggestionController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [SuggestionController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [SuggestionController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'package'], function () {
        Route::get('/list', [PackageCoinController::class, 'list'])->name('package.list');
        Route::get('/', [PackageCoinController::class, 'index'])->middleware('is_admin');
        Route::post('/store', [PackageCoinController::class, 'store'])->middleware('is_admin');
        Route::get('/show/{id}', [PackageCoinController::class, 'show'])->middleware('is_admin');
        Route::post('/update/{id}', [PackageCoinController::class, 'update'])->middleware('is_admin');
        Route::delete('/delete/{id}', [PackageCoinController::class, 'destroy'])->middleware('is_admin');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/store', [ContactController::class, 'store'])->name('contact.store');
    });

    Route::group(['prefix' => 'about'], function () {
        Route::get('/', [AboutController::class, 'index']);
        Route::post('/store', [AboutController::class, 'store']);
    });

    Route::post('/delete-all-categories', function (Request $request) {
        foreach (Category::all() as $category) {
            $category->delete();
        }
        return response()->json(['message' => 'success']);
    });//->middleware('is_admin');

    Route::group(['prefix' => 'version'], function () {
        Route::get('/latest', [VersionController::class, 'latest'])->name('latest');
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => 'contact'], function () {
    Route::get('/latest', [ContactController::class, 'latest'])->name('contact.latest');
});
Route::group(['prefix' => 'course'], function () {
    Route::get('/list-with-count', [CourseController::class, 'list_with_count']);
});

Route::get('version/latest/download', [VersionController::class, 'latest_download']);
