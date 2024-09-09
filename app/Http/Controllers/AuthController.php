<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\ForgetPasswordSMSCodeJob;
use App\Jobs\VerificationSMSCodeJob;
use App\Notifications\SMSActivationCodeNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\Wallet;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function Psl\Type\null;

/**
 * @group Authentication
 *
 * API endpoints for Authentication Services
 *
 * @subgroupDescription برای دسترسی به بخش های Authentication موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AuthController extends Controller
{
    /*******************************************
     * set middleware for exception auth methods
     ******************************************/
    public function __construct()
    {
    }

    public function forget_password(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'mobile' => 'required|ir_mobile',
        ]);
        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $user = null;
        if (User::whereMobile($request->mobile)->count()) {
            /// register senario
            $user = User::whereMobile($request->mobile)->first();
            $password = random_otp_generator();
            $user->password = Hash::make($password);
            $user->save();
            ForgetPasswordSMSCodeJob::dispatch($password, $user);
            return response()->json([
                'status' => true,
            ], HTTPResponse::HTTP_OK);
        }
        return response()->json([
            'status' => false,
        ], HTTPResponse::HTTP_OK);
    }


    /*********************************************
     * @param LoginRequest $request
     * @return JsonResponse
     * set authentication for jwt login
     * you must assign two parameters for login
     * email address and password
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('mobile', 'password');
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Invalid login details'
            ], HTTPResponse::HTTP_UNAUTHORIZED);
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'token' => $user->accesstoken
        ], HTTPResponse::HTTP_OK);
    }

    /********************************************************
     * @param RegisterRequest $request
     * @return JsonResponse|void
     * it's a method for register user and create new account.
     *********************************************************/
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
            ]);
            $user->password = Hash::make($request->password);
            $user->save();
            $credentials = $request->only('mobile', 'password');
            if (!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Invalid register details'
                ], HTTPResponse::HTTP_UNAUTHORIZED);

            return response()->json([
                'message' => 'your user created successfully',
                'status' => true,
                'token' => $user->accesstoken
            ], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function OTP(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'mobile' => 'required|ir_mobile',
        ]);
        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        try {
            $user = null;
            if (User::whereMobile($request->mobile)->count()) {
                /// login senario
                $user = User::whereMobile($request->mobile)->first();
            } else {
                /// register senario
                $user = User::create([
                    'mobile' => $request->mobile,
                ]);
                $user->assignRole(Role::findByName(Roles::Student));
                $wallet = new Wallet(['has_credit' => false, 'amount' => 0, 'bonus' => 0]);
                $user->Wallet()->save($wallet);
            }
            $userOtp = otp_generator($user);
            VerificationSMSCodeJob::dispatch($userOtp->otp, $user);
            return response()->json([
                'message' => 'successfully send code, please enter the code',
                'status' => true
            ], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'line' => $exception->getLine()], $exception->getCode());
        }
    }

    public function verifyMobile(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'code' => 'required|numeric|exists:user_otps,otp',
            'mobile' => 'required|exists:users,mobile',
        ]);
        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        $user = User::with('UserOTPs')->whereMobile($request->mobile)->first();
        $code = $request->code;
        if (!$user->userOTPs()->notExpire()->checkCode($code)->count())
            return response()->json([
                'status' => false,
                'message' => "sorry, your code invalid, maybe it's expire"
            ], HTTPResponse::HTTP_BAD_REQUEST);

        if (!Auth::loginUsingId($user->id))
            return response()->json([
                'message' => 'Invalid register details'
            ], HTTPResponse::HTTP_UNAUTHORIZED);


        return response()->json([
            'message' => 'login successfully',
            'status' => true,
            'token' => $user->accesstoken
        ], HTTPResponse::HTTP_OK);
    }

    /***************************************
     * @return JsonResponse
     * sing out user method
     ***************************************/
    public function logout(): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();
            Auth::logout();
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
