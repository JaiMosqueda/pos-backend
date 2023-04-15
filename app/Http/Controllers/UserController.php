<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Json;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {

        $response = [
            'message' => '',
            'token' => null
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            $response["message"] = $validator->errors()->first();
            return response()->json($response);
        }

        $credentials = $request->all();

        if (Auth::attempt($credentials)) {

            $user = $credentials->user();
            // $user->tokens->delete();
            // $token = $user->createToken(Auth::user()->plainTextToken);

            $token_name = "POS";

            $token = $request->user()->createToken($request->$token);

            $response["message"] ="Login successful";
            $response["token"] = $token;
            return response()->json($response);
        }

        return response()->json("Login Fail");
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->first());
        }

        $credentials = $request->all();

        var_dump($credentials["password"]);

        $credentials["password"] = Hash::make($credentials["password"]);

        var_dump($credentials["password"]);

        $user = User::create($credentials);

        if($user) {
            return response()->json(["message" => "Register Successful"]);
        }

        return response()->json(["message" => "Register Fail"]);
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
