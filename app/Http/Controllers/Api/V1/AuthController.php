<?php


namespace App\Http\Controllers\Api\V1;

use App\UserCode;
use App\Models\Profile\Profile;
use App\Models\User\User;
use App\Notifications\Activated;
use App\Notifications\Activation;
use App\Notifications\PasswordReset;
use App\Notifications\PasswordResetted;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Illuminate\Support\Facades\Log;
use Faker\Generator as Faker;
use DB;

/**
 * AuthController.
 */
class AuthController extends APIController
{
    public function checkIfUserExists(Request $request) {
        $phone = $request->only('phone');
        
        // $phone = substr($phone['phone'], 1);
        // $phone = '+254'.$phone;
        // $phone = str_replace(' ', '', $phone);

        $user = DB::table('users')->where('phone',$phone)->get();
        
        if ($user) {
        try {
        
            $code = rand(100000, 999999);
  
            UserCode::updateOrCreate([
                'user_id' => $user[0]->id,
                'code' => $code
            ]);
      
            $receiverNumber = $phone;
            $message = "Your Login OTP code is ". $code;
            $sender = "Kura";

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://prsp.jambopay.co.ke/api/api/org/disburseSingleSms/',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "number": "0708746046",
                "sms": "My message",
                "callBack": "https://....",
                "senderName": "Election Monitor"
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwYXlsb2FkIjp7ImlkIjozNywibmFtZSI6IkRldmVpbnQgTHRkIiwiZW1haWwiOiJpbmZvQGRldmVpbnQuY29tIiwibG9jYXRpb24iOiIyMyBPbGVuZ3VydW9uZSBBdmVudWUsIExhdmluZ3RvbiIsInBob25lIjoiMjU0NzQ4NDI0NzU3IiwiY291bnRyeSI6IktlbnlhIiwiY2l0eSI6Ik5haXJvYmkiLCJhZGRyZXNzIjoiMjMgT2xlbmd1cnVvbmUgQXZlbnVlIiwiaXNfdmVyaWZpZWQiOmZhbHNlLCJpc19hY3RpdmUiOmZhbHNlLCJjcmVhdGVkQXQiOiIyMDIxLTExLTIzVDEyOjQ5OjU2LjAwMFoiLCJ1cGRhdGVkQXQiOiIyMDIxLTExLTIzVDEyOjQ5OjU2LjAwMFoifSwiaWF0IjoxNjQ4NDY0MzE3fQ.D-2igZfKwTygsCzY2mQQSqLO-TY0OOF5u0LAPMZqVWM',
                'Content-Type: application/json',
                // 'DeveloperKey: 084049D0-AB72-4EE2-9EDE-0C25C1D1268C',
                // 'Password: '.hash('sha256', 'Pass@1234')
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);

            // $foundUser = DB::table('users')->where('phone',$phone)->get();
            // return $foundUser;
            return response()->json(['data' => $user, 'otp' => $code]);
        } catch (JWTException $e) {
            Log::error($ex->getMessage());
            return response()->json(['message' => 'Error']);
        }
           
        } else {
            return response()->json(['message' => 'Error']);
        }
    
    
    }
  
    public function authenticate(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        // return 'kenya';
        $credentials = request(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid Credentials! Please try again.'], 422);
             
            }
        } catch (JWTException $e) {
            Log::error($ex->getMessage());
            return response()->json(['message' => 'This is something wrong. Please try again!'], 500);
        }

        $user = DB::select('select * from users where id = '.auth()->user()->id);
        DB::table('users')
                ->where('id', auth()->user()->id)
                ->update(['status' => 'online']);

        return response()->json(['message' => 'Success','data' => $user,'token' => $token]);
    }
        /**
     * validate sms
     *
     * @return response()
     */
    public function storeOTP(Request $request)
        {
            // return $request->only('o');
            // $validated = $request->validate([
            //     // 'otp' => 'required',
            //     'phone' => 'required'
            // ]);

            $phone = $request->only('phone');
            // $phone = substr($validated['phone'], 1);
            // $phone = '+254'.$phone;
            // $phone = str_replace(' ', '', $phone);
    
            $user = DB::table('users')->where('phone', $phone)->get();

            // return $user;
        
            $exists = UserCode::where('user_id', $user[0]->id)
                    ->where('code', $request->only('otp'))
                    ->where('updated_at', '>=', now()->subMinutes(5))
                    ->latest('updated_at')
                    ->exists();
            
            if ($exists) {
                // DB::table('users')
                // ->where('id', $user->id)
                // ->update(['status' => 'activated']);
                
                return response()->json(['message' => 'Success' ,'data' => 1]);
            }
            
            return response()->json(['message' => 'Error' ,'data' => 0]);

        }
        /**
         * resend otp code
         *
         * @return response()
         */
        public function resendOTP($number)
        {
            $user = DB::table('users')->where('phone', $number)->first();


            $code = rand(100000, 999999);
  
            UserCode::updateOrCreate([
                'user_id' => $user->id,
                'code' => $code
            ]);

            return response()->json(['message' => 'We have resent OTP on your mobile number.']);

        }
    

    public function getAuthUser()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            Log::error($ex->getMessage());
            return response()->json(['authenticated' => false], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $profile = $user->Profile;
        $social_auth = ($user->password) ? 0 : 1;

        return response()->json(compact('user', 'profile', 'social_auth'));
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            Log::error($ex->getMessage());
            return response(['authenticated' => false]);
        }

        return response(['authenticated' => true]);
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }
        } catch (JWTException $e) {
            Log::error($ex->getMessage());
            return response()->json($e->getMessage(), 500);
        }

        DB::table('users')
               ->where('id', auth()->user()->id)
               ->update(['status' => 'offline']);

        // return view('auth/game');
        return response()->json(['message' => 'You are successfully logged out!']);
    }

    public function register(Request $request, Faker $faker)
    {
        str_replace(' ', '', request('phone'));
        $validation = Validator::make($request->all(), [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'phone'                 => 'required|unique:users',
            'gender'                => 'required',
            // 'allocated_area'        => 'required',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
            Log::error($ex->getMessage());
        }

        $user = User::create([
            'email'    => $faker->unique()->safeEmail,
            'status'   => 'activated',
            'password' => bcrypt(request('password')),
        ]);

        $user->activation_token = Str::uuid()->toString();
        $user->phone = str_replace(' ', '', request('phone'));
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->role = request('role');
        $user->gender = request('gender');
        $user->allocated_area = request('allocated_area');
        $user->save();

        return response()->json(['message' => 'You have registered a user successfully!']);
    }
}
