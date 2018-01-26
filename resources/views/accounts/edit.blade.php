@extends('layouts.app')

@section('content')

@php
    $video = $account['config']['video'];
    $chat  = $account['config']['chat'];
    $sms   = $account['config']['sms'];
    $email = $account['config']['email'];
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
                                <input type="password" class="form-control hideShowPassword-field secret-password" id="token" name="token" value="{{ $account->access_token }}" autocomplete="off">
                            </div>

                            <input type="hidden" name="id" value="{{$account->id}}">

                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-warning btn-sm regenerate-token" title="Refresh">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-heading">Details</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-name" class="form-horizontal" action="{{ route('accounts.update', $account->id) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="label">

                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label for="label" class="col-sm-2 control-label">Account Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="label" placeholder="Name" name="label" value="{{ $account->label }}" required autocomplete="off">
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

                <div class="panel-heading">Twilio Video</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form id="form-twilio-video" class="form-horizontal" action="{{ route('accounts.update', $account->id) }}" method="POST">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <input type="hidden" name="section" value="twilio-video">

                            <div class="form-group{{ $errors->has('twilio_video') ? ' has-error' : '' }}">
                                <label for="twilio-video" class="col-sm-2 control-label">Enabled</label>
                                <div class="col-sm-6">

                                    <input type="checkbox" id="twilio-video" name="twilio_video" value="true" {{ $video['active'] ? 'checked' : '' }}>
                                    @if ($errors->has('twilio_video'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_video') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_account_sid') ? ' has-error' : '' }}">
                                <label for="twilio-account-sid" class="col-sm-2 control-label">Account SID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-account-sid" placeholder="Account SID" name="twilio_account_sid" value="{{ $video['active'] ? $video['params']['twilio_account_sid'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_account_sid'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_account_sid') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_api_key') ? ' has-error' : '' }}">
                                <label for="twilio-api-key" class="col-sm-2 control-label">API Key</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-api-key" placeholder="API Key" name="twilio_api_key" value="{{ $video['active'] ? $video['params']['twilio_api_key'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_api_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_api_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('twilio_api_secret') ? ' has-error' : '' }}">
                                <label for="twilio-api-secret" class="col-sm-2 control-label">API secret</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="twilio-api-secret" placeholder="API Secret" name="twilio_api_secret" value="{{ $video['active'] ? $video['params']['twilio_api_secret'] : '' }}" required autocomplete="off">
                                    @if ($errors->has('twilio_api_secret'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('twilio_api_secret') }}</strong>
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

            if (this.checked) {
                inputs.removeAttr('disabled');
            } else {
                inputs.attr('disabled', true);
            }
        });

    </script>
@endsection
