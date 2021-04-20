<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support;
//use Support\Facades\Mail;
//use Illuminate\Support\Facades\Mail;

use Mail;
use Psy\Util\Str;



class ForgotController extends Controller
{
    public function Forgot(Request $request){

        //error_log($request);
        $email = $request->input('email');

        if(User::where('email',$email)->doesntExist()){
            return response([
                'message' => 'User doesnt exists'
            ],404);
        }

        //$token = Str::random(10);
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            //send email
            Mail::send('Mails.forgot',['token'=>$token],function( $message) use($email){
                   $message->to($email);
                   $message->subject('Reset your password');
            });



         return response([
             'message'=>'check your email',
             'token'=>$token
         ]);

        }catch (\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }



    public function reset(Request $request){

        $token = $request->input('token');

    if(!$passwordResets = DB::table('password_resets')->where('token',$token)->first()){
        return response([
        'message' => 'Invalid token!'
        ],400);
    }

    if(!$user= User::where('email', $passwordResets->email)->first()){
        return response([
            'message' => 'User does not exist'
        ],404);
    }


    $user -> password = Hash::make($request->input('password'));
    $user->save();

    return response([
        'message' => 'success'
    ],200);

    }




}
