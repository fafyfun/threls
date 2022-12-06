<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use function Symfony\Component\Uid\Factory\create;

class AuthController extends Controller
{
   /**
    *
    * Add New User
    * @param Request $request
    * @return User
    */

    public function newUser(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => ['required', Password::min(8)->mixedCase()],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation Error",
                    'error' => $validator->errors()

                ], 401

                );
            }

            $newUser = User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => "User Created",
                'token' => $newUser->createToken("API TOKEN")->plainTextToken

            ], 200

            );

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ], 500

            );

        }


    }

    /**
     *
     * Login Users
     * @param  Request $request
     * @return  User
     *
     */

    public function loginUser(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation Error",
                    'error' => $validator->errors()

                ], 401

                );
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => "Email & Password Does not Match",

                ], 401

                );
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'message' => "User Created",
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user_id' => $user->id

            ], 200

            );
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ], 500

            );


        }


    }

    /**
     *
     * Logout User
     * @param Request $request
     * @return
     *
     */

    public function logOut(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }


        return [
            'message' => 'user logged out'
        ];

    }

}
