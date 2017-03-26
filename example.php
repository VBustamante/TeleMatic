<?php
	require __DIR__."/vendor/autoload.php";
    require_once "src/TeleMatic.php";
	use TeleMatic\TeleMatic;
	$token 	= "";
	$tele 	= new TeleMatic("botName", $token, false);
	$cmd 	= $tele->command;
	$args 	= $tele->args;
	
	
	switch($cmd){
		case "help":
			$tele->sendMessage("I don't need any help, but thanks!");
			break;
		case "echo":
			if(count($args)){
				$msg = 'You said "';
				foreach($args as $word) $msg.="$word ";
				$msg = rtrim($msg);
				$msg .= '".';
				$tele->sendMessage($msg);
			}else $tele->sendMessage("How does silence sound in an echoey room?");
			break;
		default:
			$tele->sendMessage("My man!");
	}
?>
END