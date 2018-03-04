@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="panel-heading">Demo</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Click below to get into the respective service demo.

                    <ul>
                        <li>
                            <a href="{{ route('demo.video', ['email' => auth()->user()->email, 'room' => 'demo', 'bitrate' => 1]) }}">
                                Video
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('demo.chat', [
                                    'email' => 'os'
                                ]) }}">
                                Chat
                            </a>
                        </li>
                        <li><a href="{{ route('demo.sms') }}">SMS</a></li>
                        <li><a href="{{ route('demo.email') }}">E-mail</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
