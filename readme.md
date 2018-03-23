## API

Simple and intuitive API for building your own video conference applications.

- Make One-to-Many video calls
- Conferences with live chat
- Single presenter type conferences
- SMS Service
- Email Service

## Installation

#### Access key

Get your application Admin Access at **[Account](https://hk-services.herokuapp.com)**.

### Authentication

Get the authentication token by making a GET call to **[authentication URI](https://hk-services.herokuapp.com/api/authorize?access_token={access_token}")**

Here's a sample PHP way of making the call:

```php
$access_token = {access_token};
$url = "https://hk-services.herokuapp.com/api/authorize?access_token=" . $access_token;
$data = json_decode(file_get_contents($url));
$token = ($data) ? $data->token : 'invalid token';
```

#### Include the CSS and JS libraries

In the HTML view, add the assets that correspond to the video / chat integration.

**CSS:**
```html
<link rel="stylesheet" href="<link rel="stylesheet" href="https://hk-services.herokuapp.com/public/sdk/video.css">">
```
**JS:**
```html
<script src="https://hk-services.herokuapp.com/public/sdk/video.1.0.min.js"></script>
```

## Usage

A conference basically consists of a Local Participant, Remote Participants and a Room for them to participate. If it is a single presenter type conference, which requires a host or a presenter to start the conference. The conference can be optionally setup with text chat.

To initiate the video conference,

```javascript
var video = new Video({
    room: room,
    identity: identity,
    localVideoContainer: '#local-video-container',
    remoteVideoContainer: '#remote-video-container',
    presenterInitiation: false,
    presenterIdentity: 'presenter-identity',
    presenterVideoContainer: '#presenter-video-container',
    frameRate: 72,
    width: 4000,
    duration: 3600,
    record: true
});
```

Here, identity could be an unique identifier of the participant. `localVideoContainer`, `remoteVideoContainer`, and `presenterVideoContainer` refers to the div ids of their respective containers. You can set the presenter initiation to `true` for single presenter type video conference.

#### Connection

Pass the access key and get connected by,

```javascript
video.authenticate('{{$token}}').then(function () {
    video.connect().then(function (room) {
        video.joinRoom(room);
    });
});
```

Now, coming to the chat, follow the below code:

```javascript
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
```

For pushing any chat related info messages use the below code
```javascript
video.pushChatInfo('here is the info for the channel..');
```

To announce any specific message, use the below code:
```javascript
channel.sendMessage('broadcast message');
```
To disconnect the participant from chat channel, `channel.leave()` and to disconnect from the video conference itself, `room.disconnect()`.

## License

Pay-as-you-go subscription model. Link coming soon.
