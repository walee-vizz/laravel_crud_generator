<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingController extends Controller
{
    public function index()
    {
        // if(Auth::user()->)
        $user = Auth::user();
        $settings = AdminSetting::first();

        $data =  [
            'settings' => $settings,
            'user' => $user,
        ];


        return view('backend.settings.index', compact('settings', 'user'));
    }



    public function store(Request $request)
    {

        if ($request->aws_use_path_style_endpoint) {
            $aws_use_path_style_endpoint = 1;
        } else {
            $aws_use_path_style_endpoint = 0;
        }
        $data = [
            "mail_mailer" => $request->mail_mailer,
            "mail_host" => $request->mail_host,
            "mail_port" => $request->mail_port,
            "mail_username" => $request->mail_username,
            "mail_password" => $request->mail_password,
            "mail_encryption" => $request->mail_encryption,
            "default_email" => $request->default_email,
            "default_email_title" => $request->default_email_title,
            "google_client_id" => $request->google_client_id,
            "google_client_secret" => $request->google_client_secret,
            "google_client_redirect_uri" => $request->google_client_redirect_uri,
            "aws_secret_access_key" => $request->aws_secret_access_key,
            "aws_default_region" => $request->aws_default_region,
            "aws_bucket" => $request->aws_bucket,
            "aws_access_key_id" => $request->aws_access_key_id,
            "aws_use_path_style_endpoint" => $aws_use_path_style_endpoint,
            "paypal_client_id" => $request->paypal_client_id,
            "paypal_client_secret" => $request->paypal_client_secret,
            "paypal_currency" => $request->paypal_currency,
        ];

        $created = AdminSetting::find(1)->update($data);
        if ($created) {
            return redirect()->route('admin.settings.index')->with('success', 'Setting Saved successfully');
        } else {

            return redirect()->route('admin.settings.index')->with('success', 'Setting has failed to save');
        }
    }

    public function show(AdminSetting  $setting)
    {
        return view('backend.settings.show', compact('setting'));
    }

    public function edit(AdminSetting $setting)
    {
        return view('backend.settings.edit', compact('setting'));
    }

    public function update(Request $request, AdminSetting $setting)
    {

        if ($request->aws_use_path_style_endpoint) {
            $aws_use_path_style_endpoint = 1;
        } else {
            $aws_use_path_style_endpoint = 0;
        }
        $data = [
            "mail_mailer" => $request->mail_mailer,
            "mail_host" => $request->mail_host,
            "mail_port" => $request->mail_port,
            "mail_username" => $request->mail_username,
            "mail_password" => $request->mail_password,
            "mail_encryption" => $request->mail_encryption,
            "default_email" => $request->default_email,
            "default_email_title" => $request->default_email_title,
            "google_client_id" => $request->google_client_id,
            "google_client_secret" => $request->google_client_secret,
            "google_client_redirect_uri" => $request->google_client_redirect_uri,
            "aws_secret_access_key" => $request->aws_secret_access_key,
            "aws_default_region" => $request->aws_default_region,
            "aws_bucket" => $request->aws_bucket,
            "aws_access_key_id" => $request->aws_access_key_id,
            "aws_use_path_style_endpoint" => $aws_use_path_style_endpoint,
            "paypal_client_id" => $request->paypal_client_id,
            "paypal_client_secret" => $request->paypal_client_secret,
            "paypal_currency" => $request->paypal_currency,
        ];
        $updated = AdminSetting::find($setting->id)->update($data);
        return redirect()->route('settings.index')->with('success', 'Setting item updated successfully');
    }

    public function destroy(AdminSetting $setting)
    {

        $deleted = AdminSetting::find($setting->id)->delete();
        return redirect()->route('settings.index')->with('success', 'Setting item deleted successfully');
    }
}
