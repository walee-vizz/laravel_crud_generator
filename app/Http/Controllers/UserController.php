<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Notifications\BirthdayWish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function birthday_wish()
    {
        $user = User::find(2);

        $messages["hi"] = "Hey, Happy Birthday {$user->name}";
        $messages["wish"] = "On behalf of the entire company I wish you a very happy birthday and send you my best wishes for much happiness in your life.";

        $user->notify(new BirthdayWish($messages));

        dd('Done');
    }



    public function index()
    {
        $users = User::all();
        // dd($users);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create New User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('admin.users')->with('success', 'User has been created !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('backend.users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($request->roles) {
            $user->roles()->detach();

            $user->assignRole($request->roles);
        }

        if (Auth::id() === $user->id) {
            return redirect()->back()->with('success', 'Profile has been updated !!');
        }
        return redirect()->back()->with('success', 'User has been updated !!');
    }


    public function upload_picture(Request $request)
    {
        $mimes = [
            'png', 'jpg', 'jpeg', 'webp',
        ];

        $user = User::find($request->user_id);
        $file = $request->file('picture');
        $file_ext = $file->getClientOriginalExtension();

        if (!in_array($file_ext, $mimes)) {
            return response()->json(['error' => "Supported file types are png,jpg,jpeg,webp"]);
        }

        $file_name = time() . '-' . Str::replace(' ', '_', $user->name . '.' . $file_ext);

        $path = 'user_images/' . Str::replace(' ', '_', $user->name) . '/' . $file_name;

        $file_uploaded = $file->move(public_path('user_images/' . Str::replace(' ', '_', $user->name)), $file_name);

        if ($file_uploaded) {
            if (File::exists(public_path($user->picture))) {

                File::delete(public_path($user->picture));
            }
            $user = User::find($user->id);
            $user->picture = $path;
            if ($user->save()) {
                return response()->json(['success' => 'Image uploaded successfully.']);
            } else {
                return response()->json(['success' => 'Image uploading Failed. please try again later!']);
            }
        } else {
            return response()->json(['success' => 'Image uploading Failed. please try again later!']);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User has been deleted !!');
    }
}
