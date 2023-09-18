<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define relationships and other methods related to the model
}
