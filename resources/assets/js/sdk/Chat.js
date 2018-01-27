const TwilioVideo = require('twilio-video'),
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
}
