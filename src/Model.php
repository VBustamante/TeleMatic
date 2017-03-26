<?php
namespace TeleMatic;
class ReadOnly{
	public function __get($name) {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            return NULL;
        }
    }

    public function __set($name, $value) {
		if ( isset( $this->$name ) ) {
            throw new Exception("Tried to set nonexistent '$name' property of ".get_class($this)." class" );
        } else {
            throw new Exception("Tried to set read-only '$name' property of ".get_class($this)." class" );
        }
		return false;
    }
}

class Message extends ReadOnly{ 
	//TODO complete: https://core.telegram.org/bots/api#message
	protected $id;
	protected $sender;
	protected $chat;
	protected $text;
	protected $timestamp;
	
	public function __construct($data){
		$this->id 			= $data['message_id'];
		$this->text 		= isset($data['text'])? $data['text'] : NULL;
		$this->timestamp 	= $data['date'];
		
		$this->sender 		= new User($data['from']);//TODO this should be optional
		$this->chat 		= new Chat($data['chat']);
	}
}

class User extends ReadOnly{
	protected $id;
	protected $name;
	protected $lastName;
	protected $userName;
	
	public function __construct($data){
		$this->id 		= $data['id'];
		$this->name 	= $data['first_name'];
		
		$this->lastName = isset($data['last_name'])? $data['last_name'] : NULL;
		$this->userName = isset($data['username'])? $data['username'] : NULL;
	}
}


class Chat extends ReadOnly{
	protected $id;
	protected $type;
	protected $title;
	protected $userName;
	protected $firstName;
	protected $lastName;
	
	public function __construct($data){
		$this->id 			= $data['id'];
		$this->type			= $data['type'];
		
		$this->title		= isset($data['title'])? $data['title'] : NULL;
		$this->userName		= isset($data['username'])? $data['username'] : NULL;
		$this->firstName	= isset($data['first_name'])? $data['first_name'] : NULL;
		$this->lastName		= isset($data['last_name'])? $data['last_name'] : NULL;
		
	}
	
}