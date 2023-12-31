<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\NumberVerification;
use App\Traits\BaseValidator;
use App\Traits\ImageUploader;
use App\Traits\SendNotification;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class AuthController extends Controller
{
    use BaseValidator;
    use ImageUploader;
    use SendNotification;
    use HasApiTokens;




    public function checkMailAvailability(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required',

            ],
            [
                'email.required' => 'Please enter your email address',
                'email.unique' => 'This email address is already in use',
                'password.required' => 'Please enter a password.',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        return $this->sendResponses('This email is available');
    }




    public function sendCode(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'phone_number' => 'required|unique:users|max:255',

            ],
            [
                'phone_number.required' => 'Please enter your Phone Number address',
                'phone_number.unique' => 'This Phone Number is already in use',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $phoneNumber = $request->phone_number;
        $verificationCode = rand(100000, 999999);



        NumberVerification::where('phone_number', $phoneNumber)->delete();




        $input['phone_number'] = $phoneNumber;
        $input['verificationCode'] = $verificationCode;

        $sendCode = NumberVerification::create($input);

        if (!$sendCode) {
            return $this->sendError('An error occurred while sending the activation code');
        }

        $notification = $this->sendVerificationCode($phoneNumber, $verificationCode);

        return $this->sendResponses('Send Notification', $notification);
    }



    public function completeRegistration(Request $request)
    {
        $phoneNumber = $request->phone_number;
        $verificationCode = $request->verificationCode;

        $this->deleteExpiredCode();
        $row = NumberVerification::where('phone_number', $phoneNumber)->first();
        if ($row->phone_number != $phoneNumber || $row->verificationCode != $verificationCode) {
            return $this->sendError('The verification code is invalid');
        }

        $row->delete();


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if ($request->hasFile('profile')) {
            $input['profile'] = $this->saveImage($request, 'profile', 'user/profile');
        }


        $user = User::create($input);
        $success['profile'] = $user;
        $success['profile']['token'] = $user->createToken('accessToken')->accessToken;

        return $this->sendResponses('Account successfully created', $success);
    }
    public function deleteExpiredCode()
    {
        $tableName = 'number_verification';
        $minutes  = Carbon::now()->subMinutes(15);
        DB::table($tableName)->where('created_at', '<=', $minutes)->delete();
        return $this->sendResponses('The verification code has expired');
    }


    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255',
                'password' => 'required|max:255',
            ],
            [
                'email.required' => 'Please enter your email address.',
                'password.required' => 'Please enter a password.',
            ]
        );


        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $input = $request->all();
        if (Auth::attempt($input)) {
            $user = $request->user();
            $success['profile'] = $user;
            $success['profile']['token'] = $user->createToken('accessToken')->accessToken;
            return $this->sendResponses('User Login Successfully!', $success);
        } else {
            return $this->sendError('Incorrect email or password', 401);
        }
    }




    public function continueWithGoogle(Request $request)
    {

        
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:users|max:255',

            ],
            [
                'email.required' => 'Please enter your email address',
                'email.unique' => 'This email address is already in use',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $input = $request->all();

        $userHasAccount = User::where('email', $input['email'])->first();

        if (!$userHasAccount) {
            $user = User::create($input);
        } else {
            $user =   Auth::attempt($input);
        }

        if (!$user) {

            return    $this->sendError('An unknown error has occurred');
        }


        $success['profile'] = $user;
        $success['profile']['token'] = $user->createToken('accessToken')->accessToken;

        return $this->sendResponses(true, $success);
    }
}

    // public function logout(Request $request)
    // {
    //     $token = $request->user()->token();
    //     $token->revoke();
    //     return $this->sendResponses('User Logout Successfully');
    // }
