<?php


namespace App\API\V1\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController
{
    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/api/v1/auth/register",
     *      @OA\RequestBody(
     *          description="Auth request fields",
     *          @OA\JsonContent(
     *              type="object",
     *              required={"name", "email", "password"},
     *              @OA\Property(property="name", type="string", example="test"),
     *              @OA\Property(property="email", type="string", example="test@test.test"),
     *              @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success auth response",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="User not authorized. Wrong login or password.",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/api/v1/auth/login",
     *      @OA\RequestBody(
     *          description="Auth request fields",
     *          @OA\JsonContent(
     *              type="object",
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="test@test.test"),
     *              @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success auth response",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="User not authorized. Wrong login or password.",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/api/v1/auth/me",
     *      summary="Get the my User.",
     *      @OA\Response(
     *          response=200,
     *          description="Success auth response",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="User not authorized. Wrong login or password.",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
