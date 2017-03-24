<?php
class Config{
    private static $botConfigs = array();

    public static function getBotConfig($nomeConfig){
        if(array_key_exists($nomeConfig, self::$botConfigs)) return self::$botConfigs[$nomeConfig];
        else return NULL;
    }

    public static function _init(){
		
		
        self::$botConfigs["botName"] 		= array_key_exists("BOT_NAME", $_ENV) ? $_ENV["BOT_NAME"] 										: "botName";
        self::$botConfigs["productionMode"] 	= array_key_exists("BOT_PRODUCTION", $_ENV) ? $_ENV["BOT_PRODUCTION"] 						: false;
        
		self::$botConfigs["ApiKeyTelegram"] = array_key_exists("BOT_API_KEY_TELEGRAM", $_ENV) ? $_ENV["API_KEY_TELEGRAM"] 					: NULL;
        self::$botConfigs["ApiRequestUrl"] 	= self::$botConfigs["ApiKeyTelegram"] ? 'https://api.telegram.org/bot'.$_ENV["API_KEY_TELEGRAM"]: NULL;
        
		
        self::$botConfigs["DBHost"] 		= array_key_exists("BOT_DB_HOST", $_ENV) ? $_ENV["DB_HOST"] 									: 'localhost';
        self::$botConfigs["DBUser"] 		= array_key_exists("BOT_DB_USER", $_ENV) ? $_ENV["DB_USER"] 									: 'root';
        self::$botConfigs["DBPass"] 		= array_key_exists("BOT_DB_PASS", $_ENV) ? $_ENV["DB_PASS"] 									: 'root';
        self::$botConfigs["DBName"] 		= array_key_exists("BOT_DB_NAME", $_ENV) ? $_ENV["DB_NAME"] 									: 'telegramBot';
    }
}

Config::_init();