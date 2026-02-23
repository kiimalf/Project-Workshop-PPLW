<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use illuminate\Http\Request;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user){
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'id_google' => $googleUser->getId(),
                'password' => bcrypt(Str::random(8))
            ]);

            $otp = strtoupper(Str::random(6));
            $user->update(['otp' => $otp]);

            Mail::raw("Kode OTP Anda : $otp", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Verifikasi Akun');
            });

            session(['otp_user_id' => $user->id]);

            return redirect()->route('otp.form');


        } else {
            Auth::login($user);

            return view('home');
        }
    }

    public function otpForm() {
        return view('auth.otp');
    }

    public function otpVerify(Request $request) {
        $user = User::find(session('otp_user_id'));

        if ($user && $user->otp == $request->otp) {
            $user->update(['otp' => null]);

            Auth::login($user);

            return redirect('/home');
        }
        return back()->withErrors(['otp' => 'OTP Salah']);
    }
}
