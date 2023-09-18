<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->get();
        return view('backend/.activity_log.index', compact('logs'));
    }

    public function create()
    {
        $users = User::all();
        return view('backend/.activity_log.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'user_id' => 'required',
            'activity_type' => 'required',
        ]);

        $data = [
            'user_id' => $request->user_id,
            'activity_type' => $request->activity_type,
            'description' => $request->description,
        ];

        $created = ActivityLog::create($data);
        if($created){
            return redirect()->route('activity_log.index')->with('success', 'ActivityLog item created successfully');

        }else{
            return redirect()->route('activity_log.index')->with('error', 'ActivityLog has failed to create!');

        }
    }

    public function show(ActivityLog  $activity_log)
    {
        return view('backend/.activity_log.show', compact('activity_log'));
    }

    public function edit(ActivityLog $activity_log)
    {
        $users = User::all();

        return view('backend/.activity_log.edit', compact('activity_log', 'users'));
    }

    public function update(Request $request, ActivityLog $activity_log)
    {
        // Validate the input
        $validatedData = $request->validate([
            // Define validation rules based on your model\'s fields
            // Example: \'field_name\' => \'required|string|max:255\',
            'user_id' => 'required', 'activity_type' => 'required',
        ]);

        $updated = ActivityLog::find($activity_log->id)->update($validatedData);
        return redirect()->route('activity_log.index')->with('success', 'ActivityLog item updated successfully');
    }

    public function destroy(ActivityLog $activity_log)
    {

        $deleted = ActivityLog::find($activity_log->id)->delete();
        return redirect()->route('activity_log.index')->with('success', 'ActivityLog item deleted successfully');
    }
}
