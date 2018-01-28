const TwilioChat = require('twilio-chat'),
      $ = require('jquery'),
      m = require('moment');

class Chat {
    constructor(config) {
        this.baseUrl = 'http://localhost:9090';

        this.channel = config.channel;
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
                channel: this.channel
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
        this.clientI = client;
        return client.initialize();
    }

    chatInitiated() {
        const channelFound = this.clientI.getChannelByUniqueName(this.channel);

        this.pushChatInfo('Connecting..');

        channelFound.then(channel => {
            this.pushChatInfo('Connected');
            this.setupChatConversation(channel);
        }, error => {
            if (error.status == 404) {
                this.clientI.createChannel({
                    uniqueName: this.channel,
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
        channel.join().then(channel => {
            this.pushChatInfo('Joined as ' + this.identity);
        });

        channel.on('messageAdded', message => {
            this.pushChatMessage(message.author, message.body);
        });

        channel.on('typingStarted', member => {
            this.updateTypingIndicator(member, true);
        });

        channel.on('typingEnded', member => {
            this.updateTypingIndicator(member, false);
        });

        const input = $(this.messageInput);
        input.on('keydown', function(e) {
            if (e.keyCode == 13 && input.val() != '') {
                channel.sendMessage(input.val());
                input.val('');
            } else {
                channel.typing();
            }
        });
    }

    updateTypingIndicator(member, isTyping) {
        const el = $(this.messagesContainer);

        if (isTyping) {
            const block = `<div class="chat-message-typing-block" id="${member.state.userInfo}-typing">
                    <div class="chat-message-typing-user"> ${member.state.identity}: </div>
                    <div class="chat-message-typing-indicator"> typing.. </div>
            </div>`;

            el.append(block);
        } else {
            $(`#${member.state.userInfo}-typing`).remove();
        }
    }

    pushChatMessage(member, message) {
        const el = $(this.messagesContainer);

        const block = `<div class="chat-message-block">
                <div class="chat-user"> ${member}: </div>
                <div class="chat-message"> ${message} </div>
        </div>`;

        el.append(block);
    }

    pushChatInfo(message) {
        const el = $(this.messagesContainer);

        const info = '<div class="chat-message-info">' + message + '</div>';

        el.append(info);
    }
}


export default Chat;
