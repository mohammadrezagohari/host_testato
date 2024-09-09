<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $avatar
 * @property string|null $name
 * @property string $mobile
 * @property string|null $sex
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property int $is_enable
 * @property int|null $address_id
 * @property int $grade_id
 * @property int $field_id
 * @property int $school_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAddressId($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFieldId($value)
 * @method static Builder|User whereGradeId($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsEnable($value)
 * @method static Builder|User whereMobile($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSchoolId($value)
 * @method static Builder|User whereSex($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @property-read mixed $accesstoken
 * @property-read Collection|UserOtp[] $userOTPs
 * @property-read int|null $user_o_t_ps_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|User permission($permissions)
 * @method static Builder|User role($roles, $guard = null)
 * @property int $is_student
 * @property string $access_type
 * @property-read \App\Models\Address|null $Address
 * @property-read Collection|\App\Models\Answer[] $Answers
 * @property-read int|null $answers_count
 * @property-read Collection|\App\Models\Exam[] $Exams
 * @property-read int|null $exams_count
 * @property-read \App\Models\Field|null $Field
 * @property-read \App\Models\Grade|null $Grade
 * @property-read \App\Models\School|null $School
 * @property-read Collection|\App\Models\Story[] $Stories
 * @property-read int|null $stories_count
 * @property-read Collection|\App\Models\UserOtp[] $UserOTPs
 * @method static Builder|User whereAccessType($value)
 * @method static Builder|User whereIsStudent($value)
 * @property int|null $province_id
 * @property int|null $city_id
 * @property string|null $familiar_with_us
 * @property-read \App\Models\City|null $City
 * @property-read \App\Models\Province|null $Province
 * @method static Builder|User whereCityId($value)
 * @method static Builder|User whereFamiliarWithUs($value)
 * @method static Builder|User whereProvinceId($value)
 * @property-read Collection|\App\Models\SummaryFormula[] $SummaryFormulas
 * @property-read int|null $summary_formulas_count
 * @property-read \App\Models\Wallet|null $Wallet
 * @method static Builder|User withIndex()
 * @property-read Collection|\App\Models\UnitExercise[] $UnitExercises
 * @property-read int|null $unit_exercises_count
 * @property-read Collection|\App\Models\Bookmark[] $Bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read Collection|\App\Models\Bookmark[] $Category
 * @property-read int|null $category_count
 * @property int|null $familiar_id
 * @property-read Collection<int, \App\Models\Attendance> $Attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Familiar|null $Familiar
 * @property-read Collection<int, \App\Models\Suggestion> $Suggestions
 * @property-read int|null $suggestions_count
 * @method static Builder|User whereFamiliarId($value)
 * @property int $is_register
 * @method static Builder|User whereIsRegister($value)
 * @property int $is_admin
 * @method static Builder|User whereIsAdmin($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    #region properties
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sex',
        'name',
        'avatar',
        'password',
        'mobile',
        'is_student',
        'access_type',
        'grade_id',
        'field_id',
        'school_id',
        'is_enable',
        'city_id',
        'province_id',
        'verified_at',
        'familiar_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];
    #endregion

    #region attributes
    public function getAccesstokenAttribute()
    {
        return $this->createToken("auth_token")->plainTextToken;
    }

    public function routeNotificationForKavenegar($driver, $notification = null)
    {
        return $this->mobile;
    }
    #endregion

    #region relationships
    /********************
     * کد فعالسازی کاربر
     * @return HasMany
     *******************/
    public function UserOTPs(): HasMany
    {
        return $this->hasMany(UserOtp::class);
    }

    /******************************
     * پاسخ ها
     * @return HasMany
     */
    public function Answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /******************************
     * امتحالات
     * @return HasMany
     */
    public function Exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function Stories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class);
    }

    public function Grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function Field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function Address(): belongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function City(): belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function Province(): belongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function School(): belongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function Wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function SummaryFormulas(): HasMany
    {
        return $this->hasMany(SummaryFormula::class);
    }

    public function UnitExercises(): HasMany
    {
        return $this->hasMany(UnitExercise::class);
    }

    public function Bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function Category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function Suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class);
    }

    public function Familiar(): BelongsTo
    {
        return $this->belongsTo(Familiar::class);
    }

    public function Attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    #endregion

    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['Field', 'Grade', 'Province', 'City', 'School','Roles']);
    }

    public function scopeWhereMobile($query, $mobile)
    {
        return $query->where('mobile', '=', $mobile);
    }

    #endregion
}
