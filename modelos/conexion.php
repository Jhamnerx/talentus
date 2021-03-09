<?php

class Conexion{

	static public function conectar(){

		try {

			$link = new PDO("mysql:host=localhost;dbname=talentus",
				"root",
				"",
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	                  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
				);

			return $link;
			
		} catch (Exception $e) {
			echo 'error al conectar';
		}



	}

}