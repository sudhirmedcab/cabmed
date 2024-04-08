<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Notification extends Authenticatable
{
     // use HasFactory; 
     public function test_api (){
        return "hello world";
    }

        
    // notifications.....................................
    public function setTitle($title) {
        $this->title = $title;
    }
 
    public function setMessage($body) {
        $this->body = $body;
    }
    
    
    public function setSound($sound) {
       $this->sound = $sound;
   }
 
    public function setImage($imageUrl) {
        $this->image = $imageUrl;
    }
 
    public function setPayload($data) {
        $this->data = $data;
    }
    
    public function setKey($key) {
        $this->key = ''.$key;
    }
     public function setKey2($key2) {
        $this->key2 = $key2;
    }

    // public function setIsBackground($is_background) {
    //     $this->is_background = $is_background;
    // }
    
    // public function setIsForeground($is_foreground) {
    //     $this->is_foreground = $is_foreground;
    // }
 
   
        public function getPush() {
      $res = array();
        $res['title'] = $this->title;
        // $res['is_background'] = $this->is_background;
        // $res['is_foreground'] = $this->is_foreground;
        $res['body'] = $this->body;
        $res['sound'] = $this->sound;
        $res['image'] = $this->image;
        // $res['payload'] = $this->data;
        $res['payload'] = array(  'ticker' => $this->key2 , 'booking_id' => $this->key2 ,);
        $res['key'] = ''.$this->key.'';
         $res['booking_id'] = $this->key2;
         $res['titleLocKey'] = $this->key2;
         $res['android'] = array(  'ticker' => $this->key2 , 'sound' => 'default',);
        $res['timestamp'] = date('Y-m-d G:i:s');
        $res['ttl'] = $this->key2;
        return $res;
    }
    
     // sending push message to single user by firebase reg id
    public function send($to, $body) {
         
        $fields = array(
            'to' => $to,
            'priority' => 'high',
            'data' => $body,
            // 'notification' => $body,

        );
       // echo"token is : $to ";
        return $this->sendPushNotification($fields);
    }
 
    // Sending message to a topic by topic name
    public function sendToTopic($to, $body) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $body,
        );
        // echo"another token is : $to";
        return $this->sendPushNotification($fields);
    }
 
    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $body) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $body,
        );
      // echo"tooooooooooooo..................................$to";
        return $this->sendPushNotification($fields);
    }
 
    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
        
        // Set POST variables
        
        // echo..................to show data
        json_encode($fields);  // ...........................................response _ notification ........ pp
       
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array( 
            'Authorization: key=AAAAU5CTn9A:APA91bFd5hjqxJYwFhFUZyp9QcmW2i6TZUwxCEgbJLcTKaLTgNUZKnWtVYjUeAzWukAnikAKYInnMkkAfTP-NUvCrYyc28j3MuvKEw6KpK-KAeAZmDHZnbnnaZE6SP1KKmlGyPMACDXP' , 
            'Content-Type: application/json' 
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        // print_r($result);
    }
}