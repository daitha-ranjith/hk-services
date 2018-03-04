<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Exceptions\RestException;

class Twilio
{
    protected $account_sid;
    protected $auth_token;
    protected $api_key;
    protected $api_secret;
    protected $identity;
    protected $room;

    public function __construct($account_sid, $auth_token, $api_key, $api_secret, $room)
    {
        $this->account_sid = $account_sid;
        $this->auth_token = $auth_token;
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->room = $room;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    public function generateToken()
    {
        $token = new AccessToken(
            $this->account_sid,
            $this->api_key,
            $this->api_secret,
            3600,
            $this->identity
        );

        $this->token = $token;
    }

    public function createRoom($record)
    {
        $client = new Client($this->account_sid, $this->auth_token);

        try {
            $room = $client->video->rooms->create([
                'uniqueName' => $this->room,
                'type' => 'group',
                'recordParticipantsOnConnect' => $record,
                'StatusCallbackMethod' => 'POST',
                'statusCallback' => 'https://e09bd5be.ngrok.io/api/video/callback'
            ]);
        } catch (RestException $e) {
            //
        }

        return true;
    }

    public function getVideoToken()
    {
        $grant = new VideoGrant();
        $grant->setRoom($this->room);
        $token = $this->token->addGrant($grant);

        return $token->toJWT();
    }

    public function getChatToken($service_sid)
    {
        $endpoint = 'hktest:' . 'santosh' . ':web';

        $grant = new ChatGrant();
        $grant->setServiceSid($service_sid);
        $grant->setEndpointId($endpoint);

        $token = $this->token->addGrant($grant);

        return $token->toJWT();
    }
}
