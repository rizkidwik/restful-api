<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
/**
        * @OA\Post(
        * path="/api/login",
        * operationId="authLogin",
        * tags={"Login"},
        * summary="User Login",
        * description="Login User Here",
        * @OA\Header(
        *     description="Accept header",
        *     required=true,
        *     header="application/json",
        *),
        *     @OA\RequestBody(
        *         @OA\JsonContent(
        *            @OA\Property(property="email", type="email",format="email", example="rizki@mail.com"),
        *               @OA\Property(property="password", type="password", format="password", example="123456"),),

        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !\Hash::check($request->password, $user->password)) {
            // return response()->json([
            //     'message' => 'Invalid credentials'
            // ], 401);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }



        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Successfully logged in',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
