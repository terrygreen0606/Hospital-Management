<?php

namespace App\Http\Controllers;

use App\Events\GenerateSystemToken;
use App\Notifications\SendOtp;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name'  => "required",
            "dob"   => "required",
            "email" => "required",
            "phone" => "required|unique:users,phone",
        ]);

        $user = User::firstOrCreate([
            "phone" => preg_replace('/\D+/', '', $request->phone),
            "dob"   => $request->dob,
        ], [
            "name"  => $request->name,
            "email" => $request->email,
            "phone" => preg_replace('/\D+/', '', $request->phone),
            "dob"   => $request->dob,
            "role"  => 'patient',
        ]);
        event(new GenerateSystemToken($user));

        return $user ? response()->json(['status' => 'success'], 200) : response()->json(['status' => 'error'], 400);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            "phone" => 'required|exists:users,phone',
            "dob"   => 'required|exists:users,dob',
        ]);

        $user = User::where('phone', $request->phone)->where('otp', $request->otp)->first();

        if ($user) {
            if (Auth::guard('web')->loginUsingId($user->id, false)) {
                $token = $user->createToken('odias')->accessToken;
                return response()->json([
                    "status"  => "success",
                    "message" => "{$user->name} Logged In Successfully!",
                ])->header('Authorization', "Bearer {$token}");
            }
        }

        return response()->json([
            "status"  => "error",
            "message" => "Please Provide the right Credentials",
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function otp(Request $request)
    {
        $this->validate($request, [
            "phone" => 'required|exists:users,phone',
        ]);

        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $otp = mt_rand(100000, 999999);
            $user->update(['otp' => $otp]);
            $user->notify(new SendOtp($otp));
            return response()->json([
                "status"  => "success",
                "message" => "Please enter the 6-digit OTP sent to your phone",
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return response()->json([
            'status'  => 'success',
            'message' => 'Logged out Successfully.',
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::with('patient')->where('id', Auth::id())->first();
        return response()->json([
            'status' => 'success',
            'data'   => $user,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        if (Auth::check()) {
            $user  = Auth::user();
            $token = $user->createToken('odas')->accessToken;
            return $this->respondWithToken($token);
        } else {
            Auth::guard('web')->logout();
            return response()->json([
                'status'  => 'success',
                'logout'  => true,
                'message' => 'Logged out Successfully.',
            ], 200);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => now()->addYears(4),
        ]);
    }


    public function mirrorLogin(Request $request)
    {

        $user = User::find($request->id);
        if ($user) {
            if (Auth::guard('web')->loginUsingId($user->id, false)) {
                $token = $user->createToken('odias')->accessToken;
                return response()->json([
                    "status"  => "success",
                    "message" => "{$user->name} Logged In Successfully!",
                    "role" => $user->role
                ])->header('Authorization', "Bearer {$token}");
            }
        }

        return response()->json([
            "status"  => "error",
            "message" => "Please Provide the right Credentials",
        ]);
    }
}
