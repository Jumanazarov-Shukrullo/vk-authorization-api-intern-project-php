<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    /**
     * @throws ValidationException
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['authorize', 'register', 'feed']]);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // attempt a login (validate the credentials provided)
        $token = auth()->attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ]);

        // if token successfully generated then display success response
        // if attempt failed then "unauthenticated" will be returned automatically
        if ($token)
        {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Quote fetched successfully.',
                ],
                'data' => [
                    'user' => auth()->user(),
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ],
                ],
            ]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $passwordStrength = $this->checkPasswordStrength($request['password']);

        if ($passwordStrength === 'weak') {
            return response()->json([
                'status' => 'error',
                'message' => 'You entered a weak password. Please choose a stronger one.',
            ], 400);
        }

        $user = User::create([
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $token = auth()->login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function feed(Request $request): \Illuminate\Http\JsonResponse
    {
        if (Auth::check()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Authorized',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
    }


    private function checkPasswordStrength($password)
    {
        if (strlen($password) < 8) {
            return 'weak';
        }
        return 'good';
    }

}
