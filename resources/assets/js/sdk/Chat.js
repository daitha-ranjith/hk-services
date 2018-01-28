const TwilioChat = require('twilio-chat'),
      $ = require('jquery'),
      m = require('moment');

class Chat {
    constructor(config) {
        this.baseUrl = 'http://localhost:9090';

        this.room = config.room;
        this.identity = config.identity;
        this.messagesContainer = config.messagesContainer;
        this.messageInput = config.messageInput;
    }

    authenticate(token) {
        return $.ajax({
            method: 'POST',
            url: this.baseUrl + '/api/chat/authenticate?token=' + token,
            data: {
                identity: this.identity,
                room: this.room
            },
            dataType: 'json',
            error: error => {
                alert('Error: Check your API key.');
            },
            success: data => {
                this.data = data;
            }
        });
    }

    connect() {
        let client = new TwilioChat.Client(this.data.jwt);
        return client.initialize();
    }

    chatInitiated() {
        const channelFound = this.initializedClient.getChannelByUniqueName(this.room);

        this.pushChatInfo('Connecting..');

        channelFound.then(channel => {
            this.pushChatInfo('Connected');
            this.setupChatConversation(channel);
        }, error => {
            if (error.status == 404) {
                this.client.createChannel({
                    uniqueName: this.room,
                    friendlyName: 'General Channel'
                }).then(channel => {
                    this.chatChannel = channel;
                    this.pushChatInfo('Connected');
                    this.setupChatConversation(channel);
                });
            }
        });
    }

    setupChatConversation(channel) {
        channel.join().then((channel) => {
            this.pushChatInfo('Joined as ' + this.identity);
        });

        channel.on('messageAdded', (message) => {
            this.pushChatMessage(message.author, message.body);
        });

        const input = $(this.chatConfig.messageInput);
        input.on('keydown', function(e) {
            if (e.keyCode == 13 && input.val() != '') {
                channel.sendMessage(input.val());
                input.val('');
            }
        });
    }

    pushChatMessage(member, message) {
        const el = $(this.chatConfig.messagesContainer);

        const block = `<div class="video-chat-message-block">
                <div class="video-chat-user"> ${member}: </div>
                <div class="video-chat-message"> ${message} </div>
        </div>`;

        el.append(block);
    }

    pushChatInfo(message) {
        const el = $(this.chatConfig.messagesContainer);

        const info = '<div class="video-chat-message-info">' + message + '</div>';

        el.append(info);
    }
}


export default Chat;
