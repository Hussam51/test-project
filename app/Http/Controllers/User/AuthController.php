<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $userdata = $request->except(['category_id', 'subcategory_id']);
        $validator = Validator::make($userdata, [

            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'min:8', 'unique:users,phone_number'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'city' => ['required', 'string'],
            'bank_name' => ['required', 'string', 'min:4'],
            'statement_number' => ['required', 'numeric', 'min:3'],
            'address' => ['required', 'string', 'max:255'],
            'photo' => ['required']
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->all(), 404);

        DB::beginTransaction();
        try {
            // user create //
            $user = User::create($userdata);
            // select categories to user
            $user->categories()->attach($request->category_id);
            // select sub categories to user
            $user->subcategories()->attach($request->subcategory_id);
            DB::commit();
            $token = $user->createToken('Personal Access Token')->accessToken;
        } catch (Throwable $e) {

            return response()->json(['error' => 'there is an error in insert data'], 404);
        }
        return response()->json(['token' => $token, 'km' => $request->category_id], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'max:255', 'exists:users,email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->all(), 404);

        if (auth()->attempt($data)) {
            $token = $request->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
