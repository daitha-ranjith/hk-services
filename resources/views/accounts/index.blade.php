@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-board">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel-heading panel-board-heading">
                    ACCOUNTS
                    <a href="{{ route('accounts.create') }}" class="btn btn-xs btn-primary pull-right">
                        + Create New Account
                    </a>
                </div>

                <br>

                @foreach ($accounts as $account)
                    <div class="panel-heading">{{ $account->label }}</div>
                    <div class="panel-body text-center">
                        <form class="form-horizontal" method="POST" action="{{ route('reset-api-token') }}">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <div class="form-group">
                                <label for="token" class="col-xs-2 control-label">Token</label>
                                <div class="col-xs-8">
                                    <input type="password" class="form-control input-sm hideShowPassword-field" id="token-{{$account->id}}" name="token" value="{{ $account->access_token }}">
                                </div>
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-warning btn-sm regenerate-token" title="Refresh">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="col-md-6 col-md-offset-3">
                            <a class="btn btn-sm btn-{{$account->config['video']['active'] ? 'success' : 'danger'}}" role="button" data-toggle="collapse" href="#config-{{$account->id}}-av" aria-expanded="false" aria-controls="config-{{$account->id}}-av">Video/Audio</a>
                            <a class="btn btn-sm btn-{{$account->config['chat']['active'] ? 'success' : 'danger'}}" role="button" data-toggle="collapse" href="#config-{{$account->id}}-chat" aria-expanded="false" aria-controls="config-{{$account->id}}-chat">Chat</a>
                            <a class="btn btn-sm btn-{{$account->config['sms']['active'] ? 'success' : 'danger'}}" role="button" data-toggle="collapse" href="#config-{{$account->id}}-sms" aria-expanded="false" aria-controls="config-{{$account->id}}-sms">SMS</a>
                            <a class="btn btn-sm btn-{{$account->config['email']['active'] ? 'success' : 'danger'}}" role="button" data-toggle="collapse" href="#config-{{$account->id}}-email" aria-expanded="false" aria-controls="config-{{$account->id}}-email">E-mail</a>

                            <div class="collapse" id="config-{{$account->id}}-av">
                                <br>
                                <form class="form-horizontal" action="{{ route('tokens.update', $account->id) }}" method="POST">
                                    {{ csrf_field() }}

                                    {{ method_field('PUT') }}

                                    <div class="form-group{{ $errors->has('twilio_key_1') ? ' has-error' : '' }}">
                                        <label for="name" class="col-xs-3 control-label">Twilio Key 1</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="twilio-key-1" placeholder="Key 1" name="twilio-key-1" required>
                                            @if ($errors->has('twilio_key_1'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('twilio_key_1') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('twilio_key_2') ? ' has-error' : '' }}">
                                        <label for="name" class="col-xs-3 control-label">Twilio Key 2</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="twilio-key-2" placeholder="Key 2" name="twilio-key-2" required>
                                            @if ($errors->has('twilio_key_2'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('twilio_key_2') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('twilio_key_3') ? ' has-error' : '' }}">
                                        <label for="name" class="col-xs-3 control-label">Twilio Key 3</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="twilio-key-3" placeholder="Key 3" name="twilio-key-3" required>
                                            @if ($errors->has('twilio_key_3'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('twilio_key_3') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-default">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                @endforeach

                <div class="text-center">
                    {{ $accounts->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
