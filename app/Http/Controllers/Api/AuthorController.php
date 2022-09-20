<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //REGISTER METHOD -POST

    public function register(Request $request)
    {
        //validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:authors",
            "password" => "required |confirmed",
            "phone_no" => "required"
        ]);
        //create data

        $author = new Author();

        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone_no = $request->phone_no;
        $author->password = bcrypt($request->password);

        //save data and send response
        $author->save();

        return response()->json([
            "status" => 1,
            "message" => "Author created successfully"
        ]);
    }

    //LOGIN METHOD -POST
    public function login(Request $request)
    {
        //validation
        $login_data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        //validate author data
        if (!auth()->attempt($login_data)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"
            ]);
        }
        //token

        $token = auth()->user()->createToken("auth_token")->accessToken;
        //send response

        return response()->json([
            "status" => true,
            "message" => "Athour logged in successfully",
            "access_token" => $token
        ]);
    }

    //profile method -get
    public function profile()
    {
        //
        $user_data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "user data",
            "data" => $user_data
        ]);
    }

    //logout method get
    public function logout(Request $request)
    {
        //get toke value
        $token = $request->user()->token();

        //reovoke this token value

        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "Author logged out successfully",

        ]);
    }
}
