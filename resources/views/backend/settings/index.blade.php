@extends('layouts.backend.main')
@section('title', 'Settings')

@section('styles')

@endsection


@section('admin-content')

    <div class="container">
        <h2>Settings</h2>
        <form method="POST" action="{{ route('admin.settings.save') }}" enctype="multipart/form-data">
            @csrf
            {{-- <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="title">Application Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                    </div>
                </div>
            </div>
            <hr> --}}

            <h4 class="mb-3">Two factor Authentication Settings</h4>
            <div class="row">
                <div class="col">

                    <div class="form-group">
                        @if ($settings && $settings->google_two_fa_status)
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input mt-2 " checked id="2fa_activation"
                                    name="two_fa_activation" style="width: 36px;height:24px;">
                                <label class="form-check-label ml-3 mt-2 fs-3" style="font-size: initial;"
                                    for="2fa_activation">Disable Google Two Factor Authentication</label>
                            </div>
                            <div class="2fa_creds"><img src="" alt="qr_code" style="width:200px;" />
                                <div class="form-group"> <label>Your Google Authenticator Secret Key</label>
                                    <input type="text" class="form-control w-50" disabled name="" value="">
                                    <input type="hidden" value="" name="two_fa_secret">
                                    <input type="hidden" value="" name="two_fa_qr_url">
                                </div>
                            </div>
                        @else
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input mt-2 " id="2fa_activation"
                                    name="two_fa_activation" style="width: 36px;height:24px;">
                                <label class="form-check-label ml-3 mt-2 fs-3" style="font-size: initial;"
                                    for="2fa_activation">Enable Google Two Factor Authentication</label>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <hr>
            <h4 class="mb-3">Emails Settings</h4>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="mail_mailer">Mail Mailer</label>
                        <input type="text" name="mail_mailer" id="mail_mailer" class="form-control"
                            value="{{ old('mail_mailer', 'smtp') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="mail_host">Mail Host</label>
                        <input type="text" name="mail_host" id="mail_host" class="form-control"
                            value="{{ old('mail_host') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="mail_port">Mail Port</label>
                        <input type="text" name="mail_port" id="mail_port" class="form-control"
                            value="{{ old('mail_port') }}">
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="mail_username">Mail Username</label>
                        <input type="text" name="mail_username" id="mail_username" class="form-control"
                            value="{{ old('mail_username') }}">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col">
                    <div class="form-group">
                        <label for="mail_password">Mail Password</label>
                        <input type="password" name="mail_password" id="mail_password" class="form-control"
                            value="{{ old('mail_password') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="mail_encryption">Mail Encryption</label>
                        <input type="text" name="mail_encryption" id="mail_encryption" class="form-control"
                            value="{{ old('mail_encryption') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="default_email">Default Email</label>
                        <input type="email" name="default_email" id="default_email" class="form-control"
                            value="{{ old('default_email') }}">
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="default_email_title">Default Email Title</label>
                        <input type="text" name="default_email_title" id="default_email_title" class="form-control"
                            value="{{ old('default_email_title') }}">
                    </div>
                </div>
            </div>

            <hr>
            <h4 class="mb-3">Login With Google Settings</h4>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="google_client_id">Google Client ID</label>
                        <input type="text" name="google_client_id" id="google_client_id" class="form-control"
                            value="{{ old('google_client_id') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="google_client_secret">Google Client Secret</label>
                        <input type="text" name="google_client_secret" id="google_client_secret" class="form-control"
                            value="{{ old('google_client_secret') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="google_client_redirect_uri">Google Client Redirect URI</label>
                        <input type="text" name="google_client_redirect_uri" id="google_client_redirect_uri"
                            class="form-control" value="{{ old('google_client_redirect_uri') }}">
                    </div>
                </div>
            </div>
            <hr>


            <h4 class="mb-3">Aws Settings</h4>
            {{-- AWS creds --}}
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="aws_secret_access_key">AWS Secret Access Key</label>
                        <input type="text" name="aws_secret_access_key" id="aws_secret_access_key"
                            class="form-control" value="{{ old('aws_secret_access_key') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="aws_default_region">AWS Default Region</label>
                        <input type="text" name="aws_default_region" id="aws_default_region" class="form-control"
                            value="{{ old('aws_default_region', 'us-east-1') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="aws_bucket">AWS Bucket</label>
                        <input type="text" name="aws_bucket" id="aws_bucket" class="form-control"
                            value="{{ old('aws_bucket') }}">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="aws_access_key_id">AWS Access Key ID</label>
                        <input type="text" name="aws_access_key_id" id="aws_access_key_id" class="form-control"
                            value="{{ old('aws_access_key_id') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group"
                        style="margin-top: 6%;display: flex;justify-content: flex-start; align-items: center;">
                        <input type="checkbox" name="aws_use_path_style_endpoint mt-2" id="aws_use_path_style_endpoint"
                            value="1" {{ old('aws_use_path_style_endpoint') ? 'checked' : '' }}
                            style="width: 36px;height:24px;">
                        <label for="aws_use_path_style_endpoint"class=" ml-3 mt-2 fs-3" style="font-size: initial;">AWS
                            Use Path Style Endpoint</label>

                    </div>
                </div>
            </div>
            {{-- End --}}

            <hr>
            <h4 class="mb-3">Paypal Settings</h4>

            {{-- Paypal creds --}}
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="paypal_client_id">PayPal Client ID</label>
                        <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control"
                            value="{{ old('paypal_client_id') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="paypal_client_secret">PayPal Client Secret</label>
                        <input type="text" name="paypal_client_secret" id="paypal_client_secret" class="form-control"
                            value="{{ old('paypal_client_secret') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="paypal_currency">PayPal Currency</label>
                        <input type="text" name="paypal_currency" id="paypal_currency" class="form-control"
                            value="{{ old('paypal_currency') }}">
                    </div>
                </div>
            </div>
            {{-- End --}}












            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {


            $('#2fa_activation').on('change', function(e) {

                if ($(this).is(':checked')) {
                    // alert('df');
                    $('#2fa_activation').closest('.form-group').append(
                        '<p class="loading_qr ">Loading...</p>');
                    $('#2fa_activation').next('label').text('Disable Google Two Factor Authentication');

                    $.ajax({
                        url: "",
                        type: "GET",
                        success: function(response) {
                            const result = JSON.parse(response);
                            console.log(result);

                            if (result.url) {
                                $('#2fa_activation').closest('.form-group').find('.loading_qr')
                                    .remove();
                                $('#2fa_activation').closest('.form-group').append(
                                    `<div class="2fa_creds"><img src="${result.url}" alt="qr_code" style="width:200px;"/> <div class="form-group"> <label >Your Google Authenticator Secret Key</label><input type="text" class="form-control w-50" disabled name="" value="${result.secret}"><input type="hidden" value="${result.secret}" name="two_fa_secret"> <input type="hidden" value="${result.url}" name="two_fa_qr_url"></div> </div>`
                                )

                            } else {
                                console.log('else');
                            }

                        }
                    });
                } else {
                    $('#2fa_activation').closest('.form-group').find('.2fa_creds').remove();
                    $('#2fa_activation').next('label').text('Enable Google Two Factor Authentication');
                    // $.ajax({
                    //     url: "",
                    //     type: "GET",
                    //     success: function(response) {
                    //         const result = JSON.parse(response);

                    //         if (result.success) {
                    //             console.log('success');

                    //         } else {
                    //             console.log('error');
                    //         }

                    //     }
                    // });

                }
            })
        });
    </script>
@endsection
