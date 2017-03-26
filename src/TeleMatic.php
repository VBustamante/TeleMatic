<?php
require __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
require_once "Model.php";

class TeleMatic
{
	// Configuration
	private $botName;
	private $productionMode;//if untrue, system prints to page instead of calling api
	
	// Services
	private $httpClient;
	
	// Data Interfaces
	public $message;// Message class containing all request data
	public $command = NULL;// First word in message, if it starts with a '/'
	public $args	= NULL;// Array containing all words after command 
	
	
	public function __construct($botName, $token, $productionMode = true){
		// Parameter Variables
		$this->botName 			= $botName;
		$requestUrl 			= "https://api.telegram.org/bot".$token.'/';
		$this->productionMode 	= $productionMode;
		
		// Request Variables
		$updateRaw = file_get_contents('php://input');
		$update = json_decode($updateRaw, TRUE);
		// Create Request Object
		$message = new Message($update['message']);
		$this->message = $message;
		// Parse Command
		// TODO this deals with basic '/command args' format only. Make more versatile.
		$commandRegex = '~^/(?P<comando>[\d\w_]{1,32})(?:@'.$botName.')?~';
		if(preg_match($commandRegex, $message->text, $match)){
			$this->command = $match['comando'];
			$argsString = str_replace($match[0], "", $message->text);
			$this->args = preg_split("/ /", $argsString, NULL, PREG_SPLIT_NO_EMPTY);//Can't use explode() 'cause it puts empty strings on array
		}
		
		// System Initialization
		if($productionMode){
			$this->httpClient = new Client([
				'base_uri' => $requestUrl,
				'timeout'  => 10.0,
				'verify' => false,//TODO this is unsafe, get telegram cert somehow (?)
				// For testing with Fiddler
				//'proxy'     => "localhost:8888"
			]);
		}
	}	
	
	// If no chatId specified, response is sent to calling chat
	public function sendMessage ($message, $chatId = NULL) {
		if(!$chatId) $chatId = $this->message->sender->id;
		if($this->productionMode){
			
			$this->httpClient->request('GET', 'sendMessage', [
				'query' => [
					'chat_id'	=> $chatId,
					'text' 		=> urlencode($message),
					'parse_mode'=> 'HTML'
				]
			]);
		}else{
			echo "Text Message<br>";
			echo "$message <br>";
			echo "Sent to $chatId <br><br>";
		}
    }
	
}