@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/public/sdk/video.css">
    <style>
        #preview {
            max-width: 610px;
            max-height: 650px;
            border: none;
        }
        #remote-video-container {
            min-height: 350px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        #remote-video-container > div {
            width: 50%;
        }
        #remote-video-container > div:only-child {
            width: 100%;
        }
        #remote-video-container .plyr__video-wrapper {
            background-color: #f2f2f2;
        }
        video.remote-video {
            max-height: 350px;
        }
        #local-video-container {
            background-color: rgba(0, 0, 0, 0.18);
            min-width: 313px;
            text-align: center;
        }
        #local-video-container .plyr {
            min-width: 150px;
        }
        #local-video-container > div {
            display: inline-block;
            margin: 0 auto;
            max-width: 150px;
        }
        #chat-container {
            padding: 5px;
        }
        .chat-user {
            display: inline;
            font-weight: bold;
            color: green;
        }
        .chat-message {
            display: inline;
        }

        .chat-message-typing-user, .chat-message-typing-indicator {
            display: inline;
            font-style: italic;
            color: green;
        }
    </style>
@endsection

@section('content')
    @php
        $access_token = 'uy0boiRWoZjMB1emLj9IOPyRyrMmUJEZE3zJYbWiAWksLSLKDirBadCG25df';
        $url = "https://hk-services.herokuapp.com/api/authorize?access_token=" . $access_token;
        $data = json_decode(file_get_contents($url));
        $token = ($data) ? $data->token : 'invalid token';
        // $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwOTAvYXBpL2F1dGhvcml6ZSIsImlhdCI6MTUyMDE5MTUzNiwiZXhwIjoxNTIwMTk1MTM2LCJuYmYiOjE1MjAxOTE1MzYsImp0aSI6Im9rY3FVNDFoVko0d2VBUmciLCJzdWIiOjYsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.I8dupU-bvCYMMT3u_ylQK9Hmld0cHTqdEjpRvz6WfUA';
    @endphp

    <div class="container">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Conference Demo</div>

                    <div class="panel-body">

                        <form class="form-inline" id="conference">
                          <div class="form-group">
                            <label for="room-name">Enter the room name: </label>
                            <input type="room-name" class="form-control" id="room-name" placeholder="room name..">
                          </div>
                          <button id="connect-button" type="submit" class="btn btn-success">Connect</button>
                          <a href="#" id="disconnect-button" class="btn btn-danger disabled">Disconnect</a>
                        </form>

                        <hr>

                        <!-- Video container -->
                        <div class="col-md-8" id="videocon-container">
                            <div id="presenter-video-container"></div>
                            <div id="remote-video-container"></div>
                            <div id="local-video-container"></div>
                        </div>

                        {{-- <h4>Bitrate Adjustment</h4>
                        <hr>
                        <div>
                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                <button type="button" class="btn btn-default bitrate-button">HD Audio (40kbps)</button>
                                <button type="button" class="btn btn-default bitrate-button">Low Video + HD Audio (200kbps)</button>
                                <button type="button" class="btn btn-default bitrate-button">SD Video + HD Audio (540kbps)</button>
                                <button type="button" class="btn btn-default bitrate-button">HD Video + HD Audio (1.5Mbps)</button>
                                <button type="button" class="btn btn-danger bitrate-button">Auto</button>
                            </div>
                        </div> --}}

                        <!-- Chat container -->
                        <div class="col-md-4" id="chat-container">
                            <h4>Chat</h4>
                            <hr>
                            <div>
                                <input class="form-control" id="chat-input" type="text">
                                <br>
                            </div>
                            <div id="messages-container"></div>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">SMS Demo</div>
                    <div class="panel-body">
                    <form>
                        <div class="form-group">
                            <label for="phone-number">Phone Number</label>
                            <input type="text" class="form-control" id="phone-number" placeholder="+9199XXXX">
                        </div>
                        <div class="form-group">
                            <label for="sms-message">Message</label>
                            <textarea class="form-control" id="sms-message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Send</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/public/sdk/video.1.0.min.js"></script>
    <script src="/public/sdk/chat.1.0.min.js"></script>

    <script>
        $('#room-name').val('{{ request('room') ?: '' }}');

        var identity = '{{ request('email') }}';

        $('a#disconnect-button').click(function() {
            location.reload();
        });

        $('form#conference').submit(function (e) {
            var room = $('#room-name').val();

            if (! room) {
                alert('Enter a room name.');
            } else {
                e.preventDefault();

                $('button#connect-button').attr('disabled', 'disabled');
                $('a#disconnect-button').removeClass('disabled');

                var video = new Video({
                    room: room,
                    identity: identity,
                    localVideoContainer: '#local-video-container',
                    remoteVideoContainer: '#remote-video-container',
                    presenterInitiation: '{{ request('presenter') ?: false }}',
                    presenterIdentity: '{{ request('presenter') }}',
                    presenterVideoContainer: '#presenter-video-container',
                    frameRate: {{ request('bitrate') ?: 5  }},
                    width: 144,
                    duration: 3600,
                    record: true
                });
                video.authenticate('{{$token}}').then(function () {
                    video.connect().then(function (room) {
                        video.joinRoom(room);
                    });
                });

                var chat = new Chat({
                    channel: room,
                    identity: identity,
                    messagesContainer: '#messages-container',
                    messageInput: '#chat-input'
                });
                chat.authenticate('{{$token}}').then(function () {
                    chat.connect().then(function () {
                        chat.join();
                    });
                });

            }
        });
    </script>
@endsection
