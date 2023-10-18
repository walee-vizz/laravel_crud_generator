<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Rule('required|email')]
    public $email = '';

    #[Rule('required')]
    public $password = '';



    public function login()
    {
        $validated =  $this->validate();


        if (Auth::attempt($validated)) {
            $user = User::where('email', $validated['email'])->first();
            // dd($user);
            $log = ['user_id' => $user->id, 'activity_type' => 'Logged_in', 'description' => $user->name . ' logged in to the system.'];
            add_activity_logs($log);
            return redirect()->route('admin.dashboard');
        } else {
            request()->session()->flash('error', 'Invalid credentials');

            // return redirect()->back()->with('error', 'Invalid credentials');
        }
    }





    public function render()
    {
        return view('livewire.auth.login');
    }
}
