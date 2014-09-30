<?php

require '../dbWrapper/dbWrapper.class.php';
require 'vendor/mikecao/flight/flight/Flight.php';

//////////////////////////////////////////////////////
// Routes
//////////////////////////////////////////////////////

Flight::route('GET /', function () {
	require_once("_index.html");
});

Flight::route("POST /startInstallation", function () {
	$request = Flight::request();
	$data = $request->data;

	if (isset($data["DBName"], $data["DBHost"], $data["DBPort"], $data["DBUser"], $data["DBPassword"])) {
		$dbSettings = Array();
		// DBName
		$dbSettings[] = $data["DBName"];
		//DBUser
		$dbSettings[] = $data["DBUser"];
		//DBPassword
		$dbSettings[] = $data["DBPassword"];
		//DBHost
		$dbSettings[] = $data["DBHost"];
		//DBPort
        $dbSettings[] = $data["DBPort"];


		Flight::register( 'DB', 'dbWrapper', $dbSettings );
		$DB = Flight::DB();
		$sql = file_get_contents('../backend/sql/DB.sql');

		$connection = $DB->getConnection();
		$connection->exec($sql);

		//read the entire string
		copy("../backend/config/template_database.php", "../backend/config/database.php");
		$str = file_get_contents("../backend/config/database.php");

		//replace something in the file string - this is a VERY simple example

		$str = str_replace("%%HOST%%", $data["DBHost"],$str);
		$str = str_replace("%%PORT%%", $data["DBPort"],$str);
		$str = str_replace("%%NAME%%", $data["DBName"],$str);
		$str = str_replace("%%USER%%", $data["DBUser"],$str);
		$str = str_replace("%%PASSWORD%%", $data["DBPassword"],$str);

		file_put_contents("../backend/config/database.php", $str);
	}
});

// Initialize Flight
Flight::start();


?>
