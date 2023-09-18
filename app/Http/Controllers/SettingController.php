<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        // if(Auth::user()->)
        $user = Auth::user();
        $settings = Setting::first();

        $data =  [
            'settings' => $settings,
            'user' => $user,
        ];
        return view('backend.settings.index', compact('settings', 'user'));
    }



    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'title' => 'required', 'user_id' => 'required',
        ]);
        $data = [
            'title' => $request->title,
            'user_id' => Auth::id(),
        ];

        $created = Setting::create($validatedData);
        return redirect()->route('setting.index')->with('success', 'Setting item created successfully');
    }

    public function show(Setting  $setting)
    {
        return view('backend.settings.show', compact('setting'));
    }

    public function edit(Setting $setting)
    {
        return view('backend.settings.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        // Validate the input
        $validatedData = $request->validate([
            // Define validation rules based on your model\'s fields
            // Example: \'field_name\' => \'required|string|max:255\',
            'title' => 'required', 'user_id' => 'required',
        ]);

        $updated = Setting::find($setting->id)->update($validatedData);
        return redirect()->route('setting.index')->with('success', 'Setting item updated successfully');
    }

    public function destroy(Setting $setting)
    {

        $deleted = Setting::find($setting->id)->delete();
        return redirect()->route('setting.index')->with('success', 'Setting item deleted successfully');
    }
}
