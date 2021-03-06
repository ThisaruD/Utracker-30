<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


//add user function
    public function register(Request $request)
    {
//        error_log($request);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'user_role_id' => 'required',
            'company_name' => 'required',

        ]);

        $companyId = DB::table('companies')
            ->where('company_name', $request->input('company_name'))
            ->value('company_id');


        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'user_roles_role_id' => $validatedData['user_role_id'],
            'password' => Hash::make($validatedData['password']),
            'companies_company_id' => $companyId
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',

        ]);
    }


    //user login function
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], );
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'message' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);

    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function deleteProfile(Request $request, $id)
    {
        $vehicles = DB::table('vehicles')->where('users_id', $id)->pluck('vehicle_id')->toArray();

        if ($vehicles) {
//            return 'message'=>'Delete Existing Vehicles First';
            return response()->json([
                'message' => 'Delete Existing Vehicles First',

            ]);
        } else {

        }
        $user = DB::table('users')
            ->where('user_id', $id)
            ->delete();


        echo($user);
        if ($user) {
            return response()->json([
                'message' => 'Successfully deleted',
                 'operation' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Deletion Failed'
            ], 404);
        }

    }


    public function getUserDetails(Request $request, $id)
    {

        $user = DB::table('users')
            ->where('id', $id)
            ->get();


        if ($user) {
            return response()->json([
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => 'Cannot get user details'
            ], 404);
        }

    }


    public function updateUserDetails(Request $request, $id)
    {
        error_log($request);
        $userId = DB::table('users')
            ->where('id', $id)
            ->update(['first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'nic' => $request->nic,
                    'contact_no' => $request->contact_no,
                    'password' => Hash::make($request->password)]

            );
        //echo($userId);
        if ($userId) {
            return response()->json([
                'message1' => 'successfully updated',
            ], 200);

        } else {
            return response()->json([
                'message' => 'User not exists'], 404);

        }
    }

    public function deleteUserDetails(Request $request, $id)
    {
        //$user_id = $request->input('user_id');
        $user_id = $id;

        if ($user_id) {
            $vehicle = DB::table('vehicles')->where('users_id', $user_id)->pluck('vehicle_id')->toArray();
            if (count($vehicle) > 0) {
                return response()->json([
                    'message' => 'User has Existing Vehicles. Delete Vehicles First',
                    'operation' => 'Fail'
                    ], );
            } else {
                DB::table('users')->where('id', $user_id)->delete();
                return response()->json([
                    'message' => 'User deleted successfully',
                    'operation' => 'Success'
                    ], );

            }

        } else {
            return response()->json([
                'message' => 'User not found',
                'operation' => 'Success'
                ], );
        }
    }



    // for transport manager - get his user count
    public function getUserCount(Request $request,$id){

        $user_count = DB::table('users')
            ->where([
                ['companies_company_id',$id],
                ['user_roles_role_id',$request->user_role_id]
                ])
            ->count();


        if($user_count){
            return response([
                'message'=>'success',
                'user_count'=>$user_count
            ]);
        }else{
            return response([
                'message'=>'not found'
            ]);
        }

    }


    //for transport manager - get his user details
    public function getUsersDetails (Request $request){

        $user_details = DB::table('users')
            ->where([
                ['companies_company_id',$request->companies_company_id],
                ['user_roles_role_id',$request->user_role_id],
            ])
            ->get();

        if($user_details){
            return response([
                'message'=>'success',
                'user_details'=>$user_details
            ]);
        }else{
            return response([
                'message'=>'Not Found'
            ]);
        }

    }


}
