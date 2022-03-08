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
        $phone = substr($phone['phone'], 1);
        $phone = '+254'.$phone;
        $phone = str_replace(' ', '', $phone);

        $user = DB::table('users')->where('phone',$phone)->first();
        
        try {
        if ($user) {
            $code = rand(100000, 999999);
  
            UserCode::updateOrCreate([
                'user_id' => $user->id,
                'code' => $code
            ]);
      
            $receiverNumber = $phone;
            $message = "Your Login OTP code is ". $code;
            $sender = "Kura";
        
            
                // $basic  = new \Nexmo\Client\Credentials\Basic('cee6d9f9', 'K8BrzbcnJ0g5MGRf');
                // $client = new \Nexmo\Client($basic);
    
                // $message = $client->message()->send([
                //     'to' => $receiverNumber,
                //     'from' => $sender,
                //     'text' => $message
                // ]);

                $foundUser = DB::select('select * from users where phone ='.$phone);
                // return $foundUser;
                return response()->json(['message' => 'Success','data' => $foundUser]);
        } else {
            return response()->json(['message' => 'Error']);
        }
    } catch (JWTException $e) {
        // ..
    }
    
    }
  
    public function authenticate(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        $credentials = request(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid Credentials! Please try again.'], 422);
                // return $credentials;
            }
        } catch (JWTException $e) {
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
            // return $request->only('otp');
            $validated = $request->validate([
                'otp' => 'required',
                'phone' => 'required'
            ]);

            $phone = $validated['phone'];
            // $phone = substr($validated['phone'], 1);
            // $phone = '+254'.$phone;
            // $phone = str_replace(' ', '', $phone);
    
            $user = DB::table('users')->where('phone', $phone)->first();

            // return $user->id;
        
            $exists = UserCode::where('user_id', $user->id)
                    ->where('code', $validated['otp'])
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
        public function resend()
        {
            auth()->user()->generateCode();
    
            return back()
                ->with('success', 'We have resent OTP on your mobile number.');
        }
    

    public function getAuthUser()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
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
        $validation = Validator::make($request->all(), [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'phone'                 => 'required',
            'gender'                => 'required',
            'allocated_area'        => 'required',
            // 'role  '                => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
            Log::error($ex->getMessage());
        }

        $user = User::create([
            'email'    => request('email'),
            'status'   => 'activated',
            'password' => bcrypt(request('password')),
        ]);

        $user->activation_token = Str::uuid()->toString();
        $user->phone = request('phone');
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->role = request('role');
        $user->gender = request('gender');
        $user->allocated_area = request('allocated_area');
        $user->save();
        // $profile = new Profile();
        // $profile->first_name = request('first_name');
        // $profile->last_name = request('last_name');
        // $user->profile()->save($profile);

        // $user->notify(new Activation($user));

        return response()->json(['message' => 'You have registered a user successfully!']);
    }

    public function activate($activation_token)
    {
        $user = User::whereActivationToken($activation_token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid activation token!'], 422);
        }

        if ($user->status == 'activated') {
            return response()->json(['message' => 'Your account has already been activated!'], 422);
        }

        if ($user->status != 'pending_activation') {
            return response()->json(['message' => 'Invalid activation token!'], 422);
        }

        $user->status = 'activated';
        $user->save();
        $user->notify(new Activated($user));

        return response()->json(['message' => 'Your account has been activated!']);
    }

    public function password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
        }

        $user = User::whereEmail(request('email'))->first();

        if (!$user) {
            return response()->json(['message' => 'We couldn\'t found any user with this email. Please try again!'], 422);
        }

        $token = generateUuid();
        \DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => $token,
        ]);
        $user->notify(new PasswordReset($user, $token));

        return response()->json(['message' => 'We have sent reminder email. Please check your inbox!']);
    }

    public function validatePasswordReset(Request $request)
    {
        $validate_password_request = \DB::table('password_resets')->where('token', '=', request('token'))->first();

        if (!$validate_password_request) {
            return response()->json(['message' => 'Invalid password reset token!'], 422);
        }

        if (date('Y-m-d H:i:s', strtotime($validate_password_request->created_at.'+30 minutes')) < date('Y-m-d H:i:s')) {
            return response()->json(['message' => 'Password reset token is expired. Please request reset password again!'], 422);
        }

        return response()->json(['message' => '']);
    }

    public function reset(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
        }

        $user = User::whereEmail(request('email'))->first();

        if (!$user) {
            return response()->json(['message' => 'We couldn\'t found any user with this email. Please try again!'], 422);
        }

        $validate_password_request = \DB::table('password_resets')->where('email', '=', request('email'))->where('token', '=', request('token'))->first();

        if (!$validate_password_request) {
            return response()->json(['message' => 'Invalid password reset token!'], 422);
        }

        if (date('Y-m-d H:i:s', strtotime($validate_password_request->created_at.'+30 minutes')) < date('Y-m-d H:i:s')) {
            return response()->json(['message' => 'Password reset token is expired. Please request reset password again!'], 422);
        }

        $user->password = bcrypt(request('password'));
        $user->save();

        $user->notify(new PasswordResetted($user));

        return response()->json(['message' => 'Your password has been reset. Please login again!']);
    }

    public function changePassword(Request $request)
    {
        if (env('IS_DEMO')) {
            return response()->json(['message' => 'You are not allowed to perform this action in this mode.'], 422);
        }

        $validation = Validator::make($request->all(), [
            'current_password'          => 'required',
            'new_password'              => 'required|confirmed|different:current_password|min:6',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if (!\Hash::check(request('current_password'), $user->password)) {
            return response()->json(['message' => 'Old password does not match! Please try again!'], 422);
        }

        $user->password = bcrypt(request('new_password'));
        $user->save();

        return response()->json(['message' => 'Your password has been changed successfully!']);
    }
}
