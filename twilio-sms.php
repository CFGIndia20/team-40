<?php
require  'vendor/autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'ACf64e2b8b60cfd4273084fc519f859cfa';
$auth_token = '175706e860d2fe4094b87060298ca301';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+12029637900";

$client = new Client($account_sid, $auth_token);
$message = $client->messages->create(
    // Where to send a text message (your cell phone?)
    '+919082625021',
    array(
        'from' => $twilio_number,
        'body' => 'Dear Student, this message is a reminder for your class scheduled tomorrow! Happy Learning!'
    )
);

// print $message->sid;
print "Your message has been successfully delivered to the student!";

$sid = "ACf64e2b8b60cfd4273084fc519f859cfa"; // Your Account SID from www.twilio.com/console
$token = "175706e860d2fe4094b87060298ca301"; // Your Auth Token from www.twilio.com/console

$client = new Twilio\Rest\Client($sid, $token);
// $client->setEdge('sydney');
// Twilio.Device.setup(token, { edge: "india" });
// Read TwiML at this URL when a call connects (hold music)
$response = new Twilio\TwiML\VoiceResponse();
$response->say('Hello');
// $response->play('https://api.twilio.com/cowbell.mp3', ['loop' => 5]);
// print $response;
$call = $client->calls->create(
  '+919082625021', // Call this number
  '+12029637900', // From a valid Twilio number
  
  [
    "method" => "GET",
    "statusCallback" => "https://www.myapp.com/events",
    "statusCallbackMethod" => "POST",
    "url" => "http://demo.twilio.com/docs/voice.xml"

    //   'url' => 'https://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient'
  ]
);

// print($call->sid);
