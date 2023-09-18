<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{

    protected $table = 'admin_settings';

    protected $fillable = [
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


    // Define relationships and other methods related to the model
}
