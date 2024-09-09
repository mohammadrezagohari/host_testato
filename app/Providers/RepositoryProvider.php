<?php

namespace App\Providers;

use App\Repositories\MySQL\AdvertisementRepository\AdvertisementRepository;
use App\Repositories\MySQL\AdvertisementRepository\InterfaceAdvertisementRepository;
use App\Repositories\MySQL\AnswerRepository\AnswerRepository;
use App\Repositories\MySQL\AnswerRepository\InterfaceAnswerRepository;
use App\Repositories\MySQL\AnswerSheetRepository\AnswerSheetRepository;
use App\Repositories\MySQL\AnswerSheetRepository\InterfaceAnswerSheetRepository;
use App\Repositories\MySQL\AttendanceRepository\AttendanceRepository;
use App\Repositories\MySQL\AttendanceRepository\InterfaceAttendanceRepository;
use App\Repositories\MySQL\BaseInfoRepository\BaseInfoRepository;
use App\Repositories\MySQL\BaseInfoRepository\InterfaceBaseInfoRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Repositories\MySQL\BookmarkRepository\BookmarkRepository;
use App\Repositories\MySQL\BookmarkRepository\InterfaceBookmarkRepository;
use App\Repositories\MySQL\CategoryRepository\CategoryRepository;
use App\Repositories\MySQL\CategoryRepository\InterfaceCategoryRepository;
use App\Repositories\MySQL\CityRepository\CityRepository;
use App\Repositories\MySQL\CityRepository\InterfaceCityRepository;
use App\Repositories\MySQL\CoinRepository\CoinRepository;
use App\Repositories\MySQL\CoinRepository\InterfaceCoinRepository;
use App\Repositories\MySQL\ContactRepository\ContactRepository;
use App\Repositories\MySQL\ContactRepository\InterfaceContactRepository;
use App\Repositories\MySQL\CourseRepository\CourseRepository;
use App\Repositories\MySQL\CourseRepository\InterfaceCourseRepository;
use App\Repositories\MySQL\ExamRepository\ExamRepository;
use App\Repositories\MySQL\ExamRepository\InterfaceExamRepository;
use App\Repositories\MySQL\FamiliarRepository\FamiliarRepository;
use App\Repositories\MySQL\FamiliarRepository\InterfaceFamiliarRepository;
use App\Repositories\MySQL\FieldRepository\FieldRepository;
use App\Repositories\MySQL\FieldRepository\InterfaceFieldRepository;
use App\Repositories\MySQL\GradeRepository\GradeRepository;
use App\Repositories\MySQL\GradeRepository\InterfaceGradeRepository;
use App\Repositories\MySQL\IBaseRepository;
use App\Repositories\MySQL\LevelRepository\InterfaceLevelRepository;
use App\Repositories\MySQL\LevelRepository\LevelRepository;
use App\Repositories\MySQL\MenuRepository\InterfaceMenuRepository;
use App\Repositories\MySQL\MenuRepository\MenuRepository;
use App\Repositories\MySQL\PackageCoinRepository\InterfacePackageCoinRepository;
use App\Repositories\MySQL\PackageCoinRepository\PackageCoinRepository;
use App\Repositories\MySQL\ProfileRepository\InterfaceProfileRepository;
use App\Repositories\MySQL\ProfileRepository\ProfileRepository;
use App\Repositories\MySQL\ProvinceRepository\InterfaceProvinceRepository;
use App\Repositories\MySQL\ProvinceRepository\ProvinceRepository;
use App\Repositories\MySQL\QuestionAttachmentRepository\InterfaceQuestionAttachmentRepository;
use App\Repositories\MySQL\QuestionAttachmentRepository\QuestionAttachmentRepository;
use App\Repositories\MySQL\QuestionRepository\InterfaceQuestionRepository;
use App\Repositories\MySQL\QuestionRepository\QuestionRepository;
use App\Repositories\MySQL\RoleRepository\InterfaceRoleRepository;
use App\Repositories\MySQL\RoleRepository\RoleRepository;
use App\Repositories\MySQL\SchoolRepository\InterfaceSchoolRepository;
use App\Repositories\MySQL\SchoolRepository\SchoolRepository;
use App\Repositories\MySQL\SectionRepository\InterfaceSectionRepository;
use App\Repositories\MySQL\SectionRepository\SectionRepository;
use App\Repositories\MySQL\SliderRepository\InterfaceSliderRepository;
use App\Repositories\MySQL\SliderRepository\SliderRepository;
use App\Repositories\MySQL\StoryRepository\InterfaceStoryRepository;
use App\Repositories\MySQL\StoryRepository\StoryRepository;
use App\Repositories\MySQL\SuggestionRepository\InterfaceSuggestionRepository;
use App\Repositories\MySQL\SuggestionRepository\SuggestionRepository;
use App\Repositories\MySQL\SummaryFormulaRepository\InterfaceSummaryFormulaRepository;
use App\Repositories\MySQL\SummaryFormulaRepository\SummaryFormulaRepository;
use App\Repositories\MySQL\UnitExerciseRepository\InterfaceUnitExerciseRepository;
use App\Repositories\MySQL\UnitExerciseRepository\UnitExerciseRepository;
use App\Repositories\MySQL\UnitRepository\InterfaceUnitRepository;
use App\Repositories\MySQL\UnitRepository\UnitRepository;
use App\Repositories\MySQL\VersionRepository\InterfaceVersionRepository;
use App\Repositories\MySQL\VersionRepository\VersionRepository;
use App\Repositories\MySQL\WalletHistoryRepository\InterfaceWalletHistoryRepository;
use App\Repositories\MySQL\WalletHistoryRepository\WalletHistoryRepository;
use App\Repositories\MySQL\WalletRepository\InterfaceWalletRepository;
use App\Repositories\MySQL\WalletRepository\WalletRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IBaseRepository::class, BaseRepository::class,);
        $this->app->bind(InterfaceMenuRepository::class, MenuRepository::class,);
        $this->app->bind(InterfaceCourseRepository::class, CourseRepository::class,);
        $this->app->bind(InterfaceProfileRepository::class, ProfileRepository::class);
        $this->app->bind(InterfaceExamRepository::class, ExamRepository::class);
        $this->app->bind(InterfaceFieldRepository::class, FieldRepository::class);
        $this->app->bind(InterfaceGradeRepository::class, GradeRepository::class);
        $this->app->bind(InterfaceSectionRepository::class, SectionRepository::class);
        $this->app->bind(InterfaceSliderRepository::class, SliderRepository::class);
        $this->app->bind(InterfaceUnitRepository::class, UnitRepository::class);
        $this->app->bind(InterfaceSchoolRepository::class, SchoolRepository::class);
        $this->app->bind(InterfaceStoryRepository::class, StoryRepository::class);
        $this->app->bind(InterfaceLevelRepository::class, LevelRepository::class);
        $this->app->bind(InterfaceCityRepository::class, CityRepository::class);
        $this->app->bind(InterfaceProvinceRepository::class, ProvinceRepository::class);
        $this->app->bind(InterfaceVersionRepository::class, VersionRepository::class);
        $this->app->bind(InterfaceWalletRepository::class, WalletRepository::class);
        $this->app->bind(InterfaceSummaryFormulaRepository::class, SummaryFormulaRepository::class);
        $this->app->bind(InterfaceUnitExerciseRepository::class, UnitExerciseRepository::class);
        $this->app->bind(InterfaceWalletHistoryRepository::class, WalletHistoryRepository::class);
        $this->app->bind(InterfaceQuestionRepository::class, QuestionRepository::class);
        $this->app->bind(InterfaceAnswerRepository::class, AnswerRepository::class);
        $this->app->bind(InterfaceAnswerSheetRepository::class, AnswerSheetRepository::class);
        $this->app->bind(InterfaceBookmarkRepository::class, BookmarkRepository::class);
        $this->app->bind(InterfaceCategoryRepository::class, CategoryRepository::class);
        $this->app->bind(InterfaceAdvertisementRepository::class, AdvertisementRepository::class);
        $this->app->bind(InterfaceBaseInfoRepository::class, BaseInfoRepository::class);
        $this->app->bind(InterfacePackageCoinRepository::class, PackageCoinRepository::class);
        $this->app->bind(InterfaceContactRepository::class, ContactRepository::class);
        $this->app->bind(InterfaceSuggestionRepository::class, SuggestionRepository::class);
        $this->app->bind(InterfaceAttendanceRepository::class, AttendanceRepository::class);
        $this->app->bind(InterfaceQuestionAttachmentRepository::class, QuestionAttachmentRepository::class);
        $this->app->bind(InterfaceFamiliarRepository::class, FamiliarRepository::class);
        $this->app->bind(InterfaceRoleRepository::class, RoleRepository::class);
        $this->app->bind(InterfaceCoinRepository::class, CoinRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
