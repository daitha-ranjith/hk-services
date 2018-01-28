<?php

namespace App\Services;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;

class Twilio
{
    protected $account_sid;
    protected $api_key;
    protected $api_secret;
    protected $identity;

    public function __construct($account_sid, $api_key, $api_secret)
    {
        $this->account_sid = $account_sid;
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
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

    public function getVideoToken($room)
    {
        $grant = new VideoGrant();
        $grant->setRoom($room);
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
