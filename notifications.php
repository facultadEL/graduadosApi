<?php
class Notification{
    private $serverKey;
    public $title;
    public $message;

    function __construct()
    {
        $this->serverKey = 'AIzaSyDLgqqU21RtAMipUjvJJiLUXDc3eQOv4l0';
        $this->title = 'Graduate';
        $this->message = 'Notification';
    }

    public function setData($t,$m)
    {
        $this->title = $t;
        $this->message = $m;
    }

    public function showData()
    {
        echo $this->title."-".$this->message;
    }

    public function sendPush($to)
    {
        $registrationIds = array($to);
        $msg = array
        (
            'message' => $this->message,
            'title' => $this->title,
            'vibrate' => 1,
            'sound' => 1
            // you can also add images, additionalData
        );
        $fields = array
        (
            'registration_ids' => $registrationIds,
            'data' => $msg
        );
        $headers = array
        (
        'Authorization: key=' . $this->serverKey,
        'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;
    }
}
?>