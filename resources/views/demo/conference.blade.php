@extends('layouts.app')

@section('content')
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
        .video-chat-user {
            display: inline;
            font-weight: bold;
            color: green;
        }
        .video-chat-message {
            display: inline;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Conference Demo</div>

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

                        <!-- Videocon container -->
                        <div class="col-md-8" id="videocon-container">
                            <div id="presenter-video-container"></div>
                            <div id="remote-video-container"></div>
                            <div id="local-video-container"></div>
                        </div>

                        <!-- Chat container -->
                        <div class="col-md-4 text-center" id="bitrate" style="display:none;">
                            <h4>Bitrate Adjustment</h4>
                            <hr>
                            <div>
                                <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                    <button type="button" class="btn btn-default bitrate-button">HD Audio (40kbps)</button>
                                    <button type="button" class="btn btn-default bitrate-button">Low Video + HD Audio (200kbps)</button>
                                    <button type="button" class="btn btn-default bitrate-button">SD Video + HD Audio (540kbps)</button>
                                    <button type="button" class="btn btn-default bitrate-button">HD Video + HD Audio (1.5Mbps)</button>
                                    <button type="button" class="btn btn-danger bitrate-button">Auto</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<!-- Script(s) -->
@section('scripts')

    <script src="https://healthkon-video-api.herokuapp.com/public/sdk/video.1.1.min.js"></script>

    <script>
        $("#bitrate").hide(),$(".bitrate-button").on("click",function(){console.log("adjusting video bitrate to "+$(this).text()+"..")}),$("a#disconnect-button").click(function(){location.reload()}),$("form#conference").submit(function(e){function t(){i.connect().then(function(e){var o=i.joinRoom(e);o.status?$("#bitrate").show():setTimeout(function(){console.log("Waiting for presenter@healthkon.com"),t()},2e3)})}var o=$("#room-name").val();if(o){e.preventDefault(),$("button#connect-button").attr("disabled","disabled"),$("a#disconnect-button").removeClass("disabled");var n="{{ Auth::user()->email }}",i=new Video({identity:n,room:o,localVideoContainer:"local-video-container",remoteVideoContainer:"remote-video-container",presenterIdentity:"presenter@healthkon.com",presenterVideoContainer:"remote-video-container"});i.presenterInitiation(!1),i.setConferenceTimeout(3600),i.authorize("{{ $token }}").then(t)}else alert("Enter a room name.")});
    </script>

@endsection
