<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
class UserController extends Controller
{
    use GeneralTrait;
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:8',
            'email'=>'required|string|email|unique:users',
        ]);

        // Check if validation fails and return errors if any
        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            // Create a new user using the request data
            $user = User::create([
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'email' => $request->input('email'),
                'uuid' => Str::uuid(),
            ]);

            // Generate a token for the user
            $data['user'] = new UserResource($user);

            return $this->apiResponse($data, true, NULL , 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email'=>'required|string|email',
            'password' => 'required|min:8',
        ]);

        // Check if validation fails and return errors if any
        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            // Attempt to find the user by phone number
            $user = User::where('email', $request->input('email'))->first();

               // Verify the phone
            if (!$user) {
                return $this->apiResponse(null, false, 'Invalid email .', 401);
            }

            // Verify the password
            if (!Hash::check($request->input('password'), $user->password)) {
                return $this->apiResponse(null, false, 'Invalid  password.', 401);
            }

            // Generate a token for the user
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('MyApp')->plainTextToken;

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            if ($user) {
                $user->tokens()->delete();
                return $this->apiResponse([], true, null, 200);
            }else {
                return $this->unAuthorizeResponse();
            }

        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
}
