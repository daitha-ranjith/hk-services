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
                    <div class="panel-heading">Chat Demo</div>

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

                        <!-- Chat container -->
                        <div class="col-md-6" id="chat-container">
                            <h4>Chat</h4>
                            <hr>
                            <div>
                                <p>Type in below..</p>
                                <input class="form-control" id="chat-input" type="text">
                                <br>
                            </div>
                            <div id="messages-container"></div>
                        </div>

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
