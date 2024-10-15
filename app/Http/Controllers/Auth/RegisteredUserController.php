<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserCreateRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->string('password')),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            event(new Registered($user));

            Auth::login($user);

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed, please try again.'], 500);
        }
    }
}
