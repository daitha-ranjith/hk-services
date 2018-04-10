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
                    Click below to get into the respective service demo.

                    <ul>
                        <li>
                            <a href="{{ route('demo.video', ['email' => auth()->user()->email, 'bitrate' => 72]) }}">
                                Video
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('demo.chat', ['email' => auth()->user()->email]) }}">
                                Chat
                            </a>
                        </li>
                        <li><a href="{{ route('demo.sms') }}">SMS</a></li>
                        <li><a href="{{ route('demo.email') }}">E-mail</a></li>
                    </ul>
                </div>

                <div class="panel-heading">
                    Invite
                </div>
                <div class="panel-body">
                    <p>
                        Enter the comma separated email to invite guests to take part in the video chat conference.
                        (make sure not to enter more than 5)
                    </p>
                    <form action="{{ route('email-invite') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group" id="invite-form">
                            <label for="room">Room name</label>
                            <input type="text" name="room" class="form-control" id="room" placeholder="Room" required>
                        </div>
                        <div class="form-group" id="invite-form">
                            <label for="email-invite">Email addresses</label>
                            <input type="text" name="emails" class="form-control" id="email-invite" placeholder="Email(s)" required>
                        </div>
                        <button id="invite-button" type="submit" class="btn btn-success">Invite</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
