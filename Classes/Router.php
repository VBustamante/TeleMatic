<?php
	require_once "Config.php";
	require_once "Drivers/TelegramConnect.php";

	class Router{

		/*Espera o objeto 'message' já como array*/
		private static function processarDados($dados){
			$dadosProcessados = array();

			/*TODO inicializar objeto telegramConnect com dados da mensagem*/
			$dadosProcessados['username'] = $dados["message"]["from"]["username"];
			$dadosProcessados['chatId'] = $dados["message"]["chat"]["id"];
			$dadosProcessados['userId'] = $dados["message"]["from"]["id"];

			error_log( print_r( $dadosProcessados, true ) );

			return $dadosProcessados;
		}

		private static function processarComando($stringComando, &$args){
			/* Trata uma string que começa com '/', seguido por no maximo 32 numeros, letras ou '_', seguido ou não de '@nomeDoBot */
			$regexComando = '~^/(?P<comando>[\d\w_]{1,32})(?:@'. Config::getBotConfig('botName') .')?~';
			$comando = NULL;
			$args = NULL;

			if(preg_match($regexComando, $stringComando, $match)){
				$comando = $match['comando'];
				$stringComando = str_replace($match[0], "", $stringComando);
				$args = explode(" ", $stringComando);
			}

			error_log( print_r( $comando, true ) );
			error_log( print_r( $args, true ) );
			error_log( strlen($args[1]) );
			return $comando;
		}

		public static function direcionar($requestObj){
			$args = array();
			$comando = self::processarComando($requestObj['message']['text'], $args);
			$dados = self::processarDados($requestObj);

			$chat_id = $dados["chatId"];
			$user_id = $dados["userId"];
			$username = $dados['username'];
			
			/*Dividir cada comando em seu controlador*/
			if($username){
				$dao = new CaronaDAO();

				switch ($comando){

					case 'help':
						$help = "Brief Description:
								/remover [ida/volta] --> Comando utilizado para remover a carona da lista. SEMPRE REMOVA a carona depois dela ter sido realizada. O sistema não faz isso automaticamente. Ex: /remover ida";
						
						TelegramConnect::sendMessage($chat_id, $help);
						break;
						
					case 'id':
						$texto = "ChatId: $chat_id";

						TelegramConnect::sendMessage($chat_id, $texto);
						break;

					
				}
			}else{
				TelegramConnect::sendMessage($chat_id, "Registre seu username nas configurações do Telegram para utilizar o Bot.");
			}
		}
	}
