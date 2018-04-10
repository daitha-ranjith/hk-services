<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Service;
use App\Conference;
use App\Participant;
use App\Services\Twilio;

class VideoController extends Controller
{
    public function authenticate()
    {
        if (! Service::video()->active) {
            return response('The service has temporarily been stopped.', 503);
        }

        $identity = request()->has('identity') ? request('identity') : str_random(5);
        $room = request('room');

        $record = (request('record')) ?: false;

        $twilio = $this->setTwilio($room);
        $twilio->setIdentity($identity);
        $twilio->createRoom($record);
        $twilio->generateToken();

        return response()->json([
            'user_id' => request()->user()->id,
            'identity' => $identity,
            'jwt' => $twilio->getVideoToken()
        ]);
    }

    public function setTwilio($room)
    {
        return new Twilio(
            request('accessToken')->config['video']['params']['twilio_video_account_sid'],
            request('accessToken')->config['video']['params']['twilio_video_auth_token'],
            request('accessToken')->config['video']['params']['twilio_video_api_key'],
            request('accessToken')->config['video']['params']['twilio_video_api_secret'],
            $room,
            request('accessToken')->id
        );
    }

    public function callback($token_id)
    {
        $event = request('StatusCallbackEvent');

        try {
            if ($event == 'room-created') {
                $this->createRoom($token_id);
            }

            if ($event == 'participant-connected') {
                $this->connectParticipant();
            }

            if ($event == 'participant-disconnected') {
                $this->disconnectParticipant();
            }

            if ($event == 'room-ended') {
                $this->endRoom();
            }
        } catch (Exception $e) {
            Log::error('Video Callback Error: ' . $e->getMessage());

            return response('NOT OK', 500);
        }

        return 'OK';
    }

    private function createRoom($token_id)
    {
        Conference::create([
            'sid' => request('RoomSid'),
            'token_id' => $token_id,
            'account_sid' => request('AccountSid'),
            'name' => request('RoomName'),
            'status' => request('RoomStatus'),
            'duration' => 0
        ]);
    }

    private function connectParticipant()
    {
        $conference = Conference::where('sid', request('RoomSid'))->first();

        Participant::create([
            'conference_id' => $conference->id,
            'sid' => request('ParticipantSid'),
            'participant' => request('ParticipantIdentity'),
            'duration' => 0
        ]);
    }

    private function disconnectParticipant()
    {
        $participant = Participant::where('sid', request('ParticipantSid'))->first();
        $participant->duration = request('ParticipantDuration');
        $participant->save();
    }

    private function endRoom()
    {
        $room = Conference::where('sid', request('RoomSid'))->first();
        $room->status = request('RoomStatus');
        $room->duration = request('RoomDuration');
        $room->save();
    }

}
