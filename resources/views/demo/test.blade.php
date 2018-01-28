@php
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwOTAvYXBpL2F1dGhvcml6ZSIsImlhdCI6MTUxNzA5MDk2MSwiZXhwIjoxNTE3MDk0NTYxLCJuYmYiOjE1MTcwOTA5NjEsImp0aSI6ImVOYkM0SGZJUTcyNnZxT28iLCJzdWIiOjYsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.EyjSVS8ZS5R6ENtkHKzc4_Cw6h0-Ih3BQZXfcAAcUFw';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <link rel="stylesheet" href="/public/sdk/video.css">
</head>
<body>
    <p>Chat Test</p>
    <div id="messages-div"></div>
    <input id="chat-input"></input>

    <p>Video Test</p>
    <div id="local-video-container">local</div>
    <div id="remote-video-container">remote</div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="/public/sdk/video.1.0.min.js"></script>
    <script src="/public/sdk/chat.1.0.min.js"></script>
    <script>
        var chat = new Chat({
            room: 'some room',
            identity: '{{ request()->name }}',
            messagesContainer: 'messages-div',
            messageInput: 'chat-input'
        });

        chat.authenticate('{{$token}}').then(function () {
            chat.connect();
        });

        // var video = new Video({
        //     room: 'SomeRoom-Record-True',
        //     identity: '{{ request()->name }}',
        //     localVideoContainer: '#local-video-container',
        //     remoteVideoContainer: '#remote-video-container',
        //     presenterInitiation: true,
        //     presenterIdentity: 'santosh',
        //     presenterVideoContainer: '#presenter-video-container',
        //     width: 720,
        //     frameRate: 100
        // });

        // video.authenticate('{{$token}}').then(function () {
        //     video.connect().then(function (room) {
        //         video.joinRoom(room);
        //     });
        // });
    </script>

</body>
</html>
