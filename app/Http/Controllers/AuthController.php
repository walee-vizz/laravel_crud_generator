<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{


    public function view()
    {
        return view('auth.login');
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        // dd($request->all());

        $credantials = $request->except('_token', 'remember');

        if (Auth::attempt($credantials)) {
            $user = User::where('email', $request->email)->first();
            // dd($user);
            $log = ['user_id' => $user->id, 'activity_type' => 'Logged_in', 'description' => $user->name . ' logged in to the system.'];
            add_activity_logs($log);
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            // dd(Socialite::driver('google'));

            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('google_id', $user->id)->first();
            // dd($user);

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->route('admin.dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'picture' => $user->avatar,
                    'password' => encrypt('password')
                ]);
                $newUser->assignRole('user');

                Auth::login($newUser);

                return redirect()->route('admin.dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function create()
    {
        return view('auth.register');
    }




    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            $log = ['user_id' => $user->id, 'activity_type' => 'Registered', 'description' => $user->name . ' Registered to the system.'];
            add_activity_logs($log);
            Auth::login($user);
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Failed to register');
        }
    }










    public function logout()
    {
        $user = Auth::user();
        $log = ['user_id' => $user->id, 'activity_type' => 'Logged_out', 'description' => $user->name . ' logged out of the system.'];
        add_activity_logs($log);
        Auth::logout();
        return redirect()->route('login');
    }
}
