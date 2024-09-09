<?php

namespace App\Http\Controllers;

use App\Enums\AccessType;
use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\menu\MenuRequest;
use App\Http\Requests\profile\ProfileRequest;
use App\Http\Requests\profile\UpdateProfileRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\menu\MenuResource;
use App\Http\Resources\ProfileResource;
use App\Repositories\MySQL\MenuRepository\InterfaceMenuRepository;
use App\Repositories\MySQL\ProfileRepository\InterfaceProfileRepository;
use App\Repositories\MySQL\RoleRepository\InterfaceRoleRepository;
use Auth;
use Exception;
use Hash;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Validator;

/**
 * @group Porfile
 *
 * API endpoints for Porfile
 *
 * @subgroupDescription برای دسترسی به بخش های Porfile موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class ProfileController extends Controller
{
    private InterfaceProfileRepository $interfaceProfileRepository;
    private InterfaceRoleRepository $interfaceRoleRepository;

    public function __construct(InterfaceProfileRepository $interfaceProfileRepository,
                                InterfaceRoleRepository    $interfaceRoleRepository)
    {
        $this->interfaceProfileRepository = $interfaceProfileRepository;
        $this->interfaceRoleRepository = $interfaceRoleRepository;
    }

    /***********
     * @param Request $request
     * @return BaseCollection
     */
    public function index(Request $request): BaseCollection
    {
        $count = @$request->count ?? 10;
        $users = $this->interfaceProfileRepository->query()->withIndex()->orderByDesc("id")->paginate($count);
        return new BaseCollection($users);
    }


    /*************************************
     * @return AnonymousResourceCollection
     ************************************/
    public function list(): AnonymousResourceCollection
    {
        return ProfileResource::collection($this->interfaceProfileRepository->query()->withIndex()->get());
    }

    public function create()
    {

    }

    public function step_is_student(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'is_student' => 'required|boolean',
        ]);
        try {
            if ($validation->fails())
                return response()->json(['message' => $validation->messages()], HTTPResponse::HTTP_BAD_REQUEST);
            $user = Auth::user();
            $accessType = null;
            if ($request->is_student)
                $accessType = AccessType::Student;
            else
                $accessType = AccessType::Undefined;
            if ($this->interfaceProfileRepository->step_value($user->id, ['is_student' => $request->is_student, 'access_type' => $accessType]))
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);

        } catch (Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function step_field(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'field' => 'required|exists:fields,id',
        ]);
        if ($validation->fails())
            return response()->json(['message' => $validation->messages()], HTTPResponse::HTTP_BAD_REQUEST);

        $user = Auth::user();
        $data = [
            'field_id' => $request->field
        ];
        if ($this->interfaceProfileRepository->updateItem($user->id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);

    }

    public function step_grade(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'grade' => 'required|exists:grades,id',
        ]);
        if ($validation->fails())
            return response()->json(['message' => $validation->messages()], HTTPResponse::HTTP_BAD_REQUEST);

        $user = Auth::user();
        if ($this->interfaceProfileRepository->updateItem($user->id, ['grade_id' => $request->grade]))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);

    }

    public function step_access_type(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'access_type' => [
                'required',
                Rule::in(AccessType::ALL)
            ]
        ]);
        if ($validation->fails())
            return response()->json(['message' => $validation->messages()], HTTPResponse::HTTP_BAD_REQUEST);


        $user = Auth::user();
        if ($this->interfaceProfileRepository->updateItem($user->id, ['access_type' => $request->access_type]))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);

    }


    /***************
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function store(ProfileRequest $request): JsonResponse
    {
        $data = null;
        if ($request->name) {
            $data['name'] = $request->name;
        }
        if ($request->mobile) {
            $data['mobile'] = $request->mobile;
        }
        if ($request->is_student) {
            $data['is_student'] = $request->is_student;
        }
        if ($request->field_id) {
            $data['field_id'] = $request->field_id;
        }
        if ($request->grade_id) {
            $data['grade_id'] = $request->grade_id;
        }
        if ($request->familiar_id) {
            $data['familiar_id'] = $request->familiar_id;
        }
        if ($request->avatar) {
            $data['avatar'] = $request->avatar;
        }
        if ($request->school_id) {
            $data['school_id'] = $request->school_id;
        }
        if ($request->city_id) {
            $data['city_id'] = $request->city_id;
        }
        if ($request->province_id) {
            $data['province_id'] = $request->province_id;
        }
        if ($request->sex) {
            $data['sex'] = $request->sex;
        }
        if (@$request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if (count(@$request->roles)) {
            if ($this->interfaceRoleRepository->query()->whereIn("name", $request->roles)->whereIn("name", Roles::SuperLevel)->count()) {
                $data["is_admin"] = true;
            } else {
                $data["is_admin"] = false;
            }

        }

        if ($user = $this->interfaceProfileRepository->insertData($data)) {
            if (@$roles = $request->roles) {
                $user->assignRole($roles);
            }
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'user' => $user, 'status' => true], HTTPResponse::HTTP_OK);

        }
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return ProfileResource
     */
    public function show(int $id): ProfileResource
    {
        return ProfileResource::make($this->interfaceProfileRepository->query()->withIndex()->find($id));
    }

    /********************************************
     * get user information
     * @param int $id
     * @return ProfileResource
     * @throws AuthorizationException
     */
    public function account(int $id): ProfileResource
    {
        $item = $this->interfaceProfileRepository->query()->withIndex()->find($id);
        return ProfileResource::make($item);
    }

    /********************************
     *
     * @return ProfileResource
     * @throws AuthorizationException
     */
    public function me(): ProfileResource
    {
        $user = Auth::user();
        $item = $this->interfaceProfileRepository->query()->withIndex()->find($user->id);
        return ProfileResource::make($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateProfileRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $data = null;
        if (@$request->name) {
            $data['name'] = $request->name;
        }
        if (@$request->mobile) {
            $data['mobile'] = $request->mobile;
        }
        if (@$request->is_student) {
            $data['is_student'] = $request->is_student;
        }
        if (@$request->field_id) {
            $data['field_id'] = $request->field_id;
        }
        if (@$request->grade_id) {
            $data['grade_id'] = $request->grade_id;
        }
        if (@$request->familiar_id) {
            $data['familiar_id'] = $request->familiar_id;
        }
        if (@$request->avatar) {
            $data['avatar'] = $request->avatar;
        }
        if (@$request->school_id) {
            $data['school_id'] = $request->school_id;
        }
        if (@$request->city_id) {
            $data['city_id'] = $request->city_id;
        }
        if (@$request->province_id) {
            $data['province_id'] = $request->province_id;
        }
        if (@$request->sex) {
            $data['sex'] = $request->sex;
        }
        if (@$request->password) {
            $data['password'] = Hash::make($request->password);
        }
//        return response()->json(["data" => $request->roles]);
        if (@$request->roles) {
            if (count($request->roles)==1){
                $user = $this->interfaceProfileRepository->findById($id);
                $roles = $this->interfaceRoleRepository->query()->where('name', $request->roles[0]["name"])->whereIn("name", Roles::SuperLevel)->count();
                if ($roles) {
                    $data["is_admin"] = true;
                } else {
                    $data["is_admin"] = false;
                }
                $user->syncRoles($request->roles[0]["name"]);
            }else{
                $user = $this->interfaceProfileRepository->findById($id);
                $roles = $this->interfaceRoleRepository->query()->whereIn('name', $request->roles)->whereIn("name", Roles::SuperLevel)->count();
                if ($roles) {
                    $data["is_admin"] = true;
                } else {
                    $data["is_admin"] = false;
                }
                $user->syncRoles($request->roles);
            }
        }
        if (@$this->interfaceProfileRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*************
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function update_account(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $data = null;
            if (@$request->name) {
                $data['name'] = $request->name;
            }
            if (@$request->mobile) {
                $data['mobile'] = $request->mobile;
            }
            if (@$request->password) {
                $data['password'] = Hash::make($request->password);
            }
            if (@$request->is_student) {
                $data['is_student'] = $request->is_student;
            }
            if (@$request->field_id) {
                $data['field_id'] = $request->field_id;
            }
            if (@$request->grade_id) {
                $data['grade_id'] = $request->grade_id;
            }
            if (@$request->familiar_id) {
                $data['familiar_id'] = $request->familiar_id;
            }
            if (@$request->avatar) {
                $data['avatar'] = $request->avatar;
            }
            if (@$request->school_id) {
                $data['school_id'] = $request->school_id;
            }
            if (@$request->city_id) {
                $data['city_id'] = $request->city_id;
            }
            if (@$request->province_id) {
                $data['province_id'] = $request->province_id;
            }
            if (@$request->sex) {
                $data['sex'] = $request->sex;
            }
            if ($this->interfaceProfileRepository->updateItem($userId, $data))
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);

        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    /***************
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            if (@$user = $this->interfaceProfileRepository->findById($id)) {
                if ($this->interfaceProfileRepository->deleteUser($user))
                    return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            }
            return response()->json(['message' => 'deleted item past time', 'status' => false], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), HTTPResponse::HTTP_EXPECTATION_FAILED]);
        }
    }


    public function Statistic()
    {
        return $this->interfaceProfileRepository->quantity();
    }

}
