@php
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwOTAvYXBpL2F1dGhvcml6ZSIsImlhdCI6MTUxNjA5NjM1NywiZXhwIjoxNTE2MDk5OTU3LCJuYmYiOjE1MTYwOTYzNTcsImp0aSI6IjNRMjRjY3FWUUFaRUtKREMiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.syO__fiN9oPSbPQ2Fp09yEfV7aJIylnW4-mcmJzinlY';
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
    <p>this is the para in between</p>
    <div id="remote-video-container">remote</div>

    <script src="/public/sdk/video.1.0.min.js"></script>
    <script>
        var video = new Video({
            identity: '{{ request()->name }}',
            presenterIdentity: 'Santosh',
            room: 'SomeRoom',
            localVideoContainer: '#local-video-container',
            remoteVideoContainer: '#remote-video-container',
            presenterVideoContainer: '#presenter-video-container'
        });

        video.authenticate('{{$token}}').then(function () {
            video.connect().then(function (room) {
                video.joinRoom(room);
            });
        });
    </script>

    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <script>
        let v = $.ajax({
            method: 'POST',
            url: '/api/video/authenticate?token=' + '{{ $token }}',
            data: {
                identity: '{{ request()->name }}'
            },
            dataType: 'json',
            error: (error) => {
                alert('Error: Check your API key.');
            },
            success: (data) => {
                Twilio.Video.createLocalTracks().then(localTracks => {
                    Twilio.Video.connect(
                        data.jwt,
                        {
                            name: 'demo',
                            tracks: localTracks
                        }
                    ).then(room => {
                        const localParticipant = room.localParticipant;

                        const container = $('#local-video-container');
                        const wrapper = document.createElement('div');
                        const video = document.createElement('video');

                        localParticipant.tracks.forEach(track => {
                            if (track.kind == 'video') {

                                wrapper.appendChild(video);
                                video.setAttribute('controls', true);
                                video.setAttribute('autoplay', true);
                                video.setAttribute('muted', true);
                                video.setAttribute('id', track.id);

                                let m = new MediaStream;
                                m.addTrack(track.mediaStreamTrack);

                                video.srcObject = m;
                                container.html(wrapper);
                            }
                        });


                        // localParticipant.tracks.forEach(track => {
                        //     console.log('You, "%s", are now connected to the room', localParticipant.identity);
                        //     document.getElementById('local-video-container').appendChild(track.attach());
                        // });
                        // // existing
                        // room.participants.forEach(participant => {
                        //     console.log('Participant "%s" is already connected to the Room', participant.identity);
                        //     participant.on('trackAdded', track => {
                        //         document.getElementById('remote-video-container').appendChild(track.attach());
                        //     });
                        // });
                        // // connected
                        // room.once('participantConnected', participant => {
                        //     console.log('Participant "%s" has connected to the Room', participant.identity);
                        //     participant.on('trackAdded', track => {
                        //         document.getElementById('remote-video-container').appendChild(track.attach());
                        //     });
                        // });
                        // // disconnected
                        // room.once('participantDisconnected', participant => {
                        //     console.log('Participant "%s" has disconnected from Room', participant.identity);
                        // });
                    });
                });
            }
        });
    </script> -->
</body>
</html>
