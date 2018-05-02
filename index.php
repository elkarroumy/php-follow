<?php

	require_once 'vendor/autoload.php';

	$api = new \InstagramAPI\Instagram(false);
	$pdo = new PDO("mysql:host=localhost;dbname=instabots","root","123456");
	try {
		
		$logUsername = readline("Please enter your username: ");
		$logPassword = readline("Please enter your password: ");

		$login = $api->login($logUsername,$logPassword);

		echo "You're logged in..";

		$username = readline("Please enter follow-up account username: ");

		$rankToken = \InstagramAPI\Signatures::generateUUID();

		$id = $api->people->getUserIdForName( $username );

		$followers = $api->people->getFollowers($id,$rankToken);
		$followers = json_decode($followers);
		$followers = $followers->users;

		$i = 1;
		foreach ($followers as $key => $value) {
			$follow = $api->people->follow( $value->pk );
			if( $follow ){
				echo "success - ".$i."\n";
				$i++;
			}else
				echo "danger!!";
			/**
			 *	For not to exceed the (Instagram) rules
			 */
			sleep( rand(60,75 ) );
		}
		
	}catch(Exception $e){
		echo $e->getMessage();
	}	
