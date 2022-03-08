<?php

namespace App\Http\Controllers;

use App\UserCode;
use Illuminate\Http\Request;

class TwoFactorAuthController extends Controller
{
    /**
     * index method for 2fa
     *
     * @return response()
     */
    public function index()
    {
        return response()->json(['message' => 'OTP code!']);
    }

    /**
     * validate sms
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required',
        ]);
  
        $exists = UserCode::where('user_id', auth()->user()->id)
                ->where('code', $validated['otp'])
                ->where('updated_at', '>=', now()->subMinutes(5))
                ->exists();
  
        if ($exists) {
            DB::table('users')
               ->where('id', auth()->user()->id)
               ->update(['status' => 'activated']);
            
            return response()->json(['message' => 'You have entered the correct OTP code!']);
        }
  
        return response()->json(['message' => 'You have entered the wronf OTP code!']);
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
}