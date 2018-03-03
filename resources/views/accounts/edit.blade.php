@extends('layouts.app')

@section('content')

@php
    $video = $subAccount['config']['video'];
    $chat  = $subAccount['config']['chat'];
    $sms   = $subAccount['config']['sms'];
    $email = $subAccount['config']['email'];
@endphp

<div class="container">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel-heading">Account</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-token" class="form-horizontal" method="POST" action="{{ route('reset-api-token') }}">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <label for="token" class="col-sm-2 control-label">Access Token</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control hideShowPassword-field secret-password" id="token" name="token" value="{{ $subAccount->access_token }}" autocomplete="off">
                            </div>

                            <input type="hidden" name="id" value="{{$subAccount->id}}">

                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-warning btn-sm regenerate-token" title="Refresh">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-heading">Name</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-name" class="form-horizontal" action="{{ route('sub-accounts.update', [$accountId, $subAccount->id]) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="label">

                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label for="label" class="col-sm-2 control-label">Account Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="label" placeholder="Name" name="label" value="{{ $subAccount->label }}" required autocomplete="off">
                                    @if ($errors->has('label'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('label') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-heading">Video</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-twilio-video" class="form-horizontal" action="{{ route('sub-accounts.update', [$accountId, $subAccount->id]) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="twilio-video">

                            <div class="form-group">
                                <label for="twilio-video" class="col-sm-2 control-label">Enabled</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" id="twilio-video" name="twilio_video" value="true" {{ $video['active'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_video_account_sid') ? ' has-error' : '' }}">
                                <label for="twilio-video-account-sid" class="col-sm-2 control-label">Account SID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-video-account-sid" placeholder="Account SID" name="twilio_video_account_sid" value="{{ $video['active'] ? $video['params']['twilio_video_account_sid'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_video_account_sid'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_video_account_sid') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_video_auth_token') ? ' has-error' : '' }}">
                                <label for="twilio-video-auth-token" class="col-sm-2 control-label">Account SID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-video-auth-token" placeholder="Auth Token" name="twilio_video_auth_token" value="{{ $video['active'] ? $video['params']['twilio_video_auth_token'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_video_auth_token'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_video_auth_token') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_video_api_key') ? ' has-error' : '' }}">
                                <label for="twilio-video-api-key" class="col-sm-2 control-label">API Key</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-video-api-key" placeholder="API Key" name="twilio_video_api_key" value="{{ $video['active'] ? $video['params']['twilio_video_api_key'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_video_api_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_video_api_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_video_api_secret') ? ' has-error' : '' }}">
                                <label for="twilio-video-api-secret" class="col-sm-2 control-label">API secret</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-video-api-secret" placeholder="API Secret" name="twilio_video_api_secret" value="{{ $video['active'] ? $video['params']['twilio_video_api_secret'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_video_api_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_video_api_secret') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-heading">Chat</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-twilio-chat" class="form-horizontal" action="{{ route('sub-accounts.update', [$accountId, $subAccount->id]) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="twilio-chat">

                            <div class="form-group">
                                <label for="twilio-chat" class="col-sm-2 control-label">Enabled</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" id="twilio-chat" name="twilio_chat" value="true" {{ $chat['active'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_chat_account_sid') ? ' has-error' : '' }}">
                                <label for="twilio-chat-account-sid" class="col-sm-2 control-label">Account SID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-chat-account-sid" placeholder="Account SID" name="twilio_chat_account_sid" value="{{ $chat['active'] ? $chat['params']['twilio_chat_account_sid'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_chat_account_sid'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_chat_account_sid') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_chat_api_key') ? ' has-error' : '' }}">
                                <label for="twilio-chat-api-key" class="col-sm-2 control-label">API Key</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-chat-api-key" placeholder="API Key" name="twilio_chat_api_key" value="{{ $chat['active'] ? $chat['params']['twilio_chat_api_key'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_chat_api_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_chat_api_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_chat_api_secret') ? ' has-error' : '' }}">
                                <label for="twilio-chat-api-secret" class="col-sm-2 control-label">API secret</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-chat-api-secret" placeholder="API Secret" name="twilio_chat_api_secret" value="{{ $chat['active'] ? $chat['params']['twilio_chat_api_secret'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_chat_api_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_chat_api_secret') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_chat_service_sid') ? ' has-error' : '' }}">
                                <label for="twilio-chat-service-sid" class="col-sm-2 control-label">Service SID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-chat-service-sid" placeholder="Service SID" name="twilio_chat_service_sid" value="{{ $chat['active'] ? $chat['params']['twilio_chat_service_sid'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_chat_service_sid'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_chat_service_sid') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-heading">SMS</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-twilio-sms" class="form-horizontal" action="{{ route('sub-accounts.update', [$accountId, $subAccount->id]) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="twilio-sms">

                            <div class="form-group">
                                <label for="twilio-sms" class="col-sm-2 control-label">Enabled</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" id="twilio-sms" name="twilio_sms" value="true" {{ $sms['active'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_sms_account_sid') ? ' has-error' : '' }}">
                                <label for="twilio-sms-account-sid" class="col-sm-2 control-label">Account SID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-sms-account-sid" placeholder="Account SID" name="twilio_sms_account_sid" value="{{ $sms['active'] ? $sms['params']['twilio_sms_account_sid'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_sms_account_sid'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_sms_account_sid') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_sms_auth_token') ? ' has-error' : '' }}">
                                <label for="twilio-sms-auth-token" class="col-sm-2 control-label">Auth Token</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-sms-auth-token" placeholder="Token" name="twilio_sms_auth_token" value="{{ $sms['active'] ? $sms['params']['twilio_sms_auth_token'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_sms_auth_token'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_sms_auth_token') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-heading">E-mail</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-email" class="form-horizontal" action="{{ route('sub-accounts.update', [$accountId, $subAccount->id]) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="email">

                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Enabled</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" id="email" name="email" value="true" {{ $email['active'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email_smtp_host') ? ' has-error' : '' }}">
                                <label for="email-smtp-host" class="col-sm-2 control-label">SMTP Host</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email-smtp-host" placeholder="Host" name="email_smtp_host" value="{{ $email['active'] ? $email['params']['email_smtp_host'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('email_smtp_host'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_smtp_host') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email_smtp_port') ? ' has-error' : '' }}">
                                <label for="email-smtp-port" class="col-sm-2 control-label">SMTP Port</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email-smtp-port" placeholder="Port" name="email_smtp_port" value="{{ $email['active'] ? $email['params']['email_smtp_port'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('email_smtp_port'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_smtp_port') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email_smtp_username') ? ' has-error' : '' }}">
                                <label for="email-smtp-username" class="col-sm-2 control-label">SMTP Username</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email-smtp-username" placeholder="Username" name="email_smtp_username" value="{{ $email['active'] ? $email['params']['email_smtp_username'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('email_smtp_username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_smtp_username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email_smtp_password') ? ' has-error' : '' }}">
                                <label for="email-smtp-password" class="col-sm-2 control-label">SMTP Password</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email-smtp-password" placeholder="Password" name="email_smtp_password" value="{{ $email['active'] ? $email['params']['email_smtp_password'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('email_smtp_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_smtp_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>

        $("input[type=checkbox]").change(function () {
            var form = $(this).closest('form');
            var inputs = form.find('input[type=text]');

            if (! $(this).is(':checked')) {
                inputs.attr('disabled', true);
            }

            if (this.checked) {
                inputs.removeAttr('disabled');
            } else {
                inputs.attr('disabled', true);
            }
        });

    </script>
@endsection
