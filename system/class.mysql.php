<?php

	class MysqlClass{
		
		public static $config;
	
		final function __construct(){
			try{
				self::getconfig();
				self::definevars();
			}
			catch(Exception $e){
				trigger_error('Error in '. __FUNCTION__ . ' more info: '. $e->getMessage);
			}
		}
		final function getconfig(){
			
			if (file_exists( __DIR__ . DIRECTORY_SEPARATOR . 'class.config.php')){
				require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.config.php');
				self::$config = $config;
			}else{
				die('No se ha podido encontrar el archivo class.config.php');
			}
		}
		final function definevars(){
			foreach(self::$config as $var => $value){
				if(!defined($var))
					define($var, $value);
			}
		}
		final function database(){
				require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class.database.php');
				return new Database(DB_HOST, DB_PORT, DB_USER,
									DB_PASSWORD, DB_DATABASE);	
		}
	}
?>