<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';

    protected $fillable = [
        'title',
        'user_id',
        'google_two_fa_status',
        'google_two_fa_secret',
        'google_two_fa_qr_url',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'default_email',
        'default_email_title',
        'aws_access_key_id',
        'aws_secret_access_key',
        'aws_default_region',
        'aws_bucket',
        'aws_use_path_style_endpoint',
        'paypal_client_id',
        'paypal_client_secret',
        'paypal_currency',
        'google_client_id',
        'google_client_secret',
        'google_client_redirect_uri',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Define relationships and other methods related to the model
}
