<?php

// Maintains list of email for subscribers
class Mailer {
	public static $message;
	public function __construct($new){
		echo 'Mailer object created' . '<br />';
		this->sendMessage();
	}
	// To send Message
	function sendMessage(){
		echo 'Message Sent' . '<br />';
	}
	// To add subscriber
	function addSubscriber(){
		echo 'Subscriber Added' . '<br />';
	}
}


class Watcher {	
	public static $message;
	public function __construct($msg){
		self::$message = $msg;
		echo 'Watcher object created' . '<br />';
	}
}

$notifyMessage = new Mailer(new Watcher($newMessage));

$notifyMessage->addSubscriber();

?>