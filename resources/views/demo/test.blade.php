@php
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwOTAvYXBpL2F1dGhvcml6ZSIsImlhdCI6MTUxNjM5MzYwNCwiZXhwIjoxNTE2Mzk3MjA0LCJuYmYiOjE1MTYzOTM2MDQsImp0aSI6IlVXdHJtaDc1bEJpdmcxbWkiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.I0BQnfR56cKxIW5RPiV392dRyPLMBzwt_NS11dDocd4';
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
        });

        video.authenticate('{{$token}}').then(function () {
            video.connect().then(function (room) {
                var c = video.joinRoom(room);
                if (! c.status) {
                    alert(c.message);
                }
            });
        });
    </script>

</body>
</html>
