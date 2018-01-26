@php
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwOTAvYXBpL2F1dGhvcml6ZSIsImlhdCI6MTUxNjk1OTYyMywiZXhwIjoxNTE2OTYzMjIzLCJuYmYiOjE1MTY5NTk2MjMsImp0aSI6Ilo0ZXhCd3BuVWFZTG1sUlUiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.d-zUAC73dms-QvsTcdShvQNgWMV1o2UIdKcsFIYgPGE';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <link rel="stylesheet" href="https://sandbox.healthkon.com/rural/public/av/public/public/video.css">
</head>
<body>
    <p>Test</p>
    <div id="local-video-container">local</div>
    <div id="remote-video-container">remote</div>

    <input type="text" id="width">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="/public/sdk/video.1.0.min.js"></script>
    <script>
        var video = new Video({
            room: 'SomeRoom-Record-True',
            identity: '{{ request()->name }}',
            localVideoContainer: '#local-video-container',
            remoteVideoContainer: '#remote-video-container',
            presenterInitiation: true,
            presenterIdentity: 'santosh',
            presenterVideoContainer: '#presenter-video-container',
            width: 720,
            frameRate: 100
        });

        video.authenticate('{{$token}}').then(function () {
            video.connect().then(function (room) {
                video.joinRoom(room);
            });
        });
    </script>

</body>
</html>
