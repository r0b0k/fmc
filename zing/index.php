<?php
	include_once('../includes/connection.php');

	$dir = '../img';
	$images = array_diff(scandir($dir), array('..', '.'));

	$query = $pdo->prepare('TRUNCATE TABLE images');
	$query->execute();	

	foreach ($images as $imagen) {
		$query = $pdo->prepare('INSERT INTO images (image_path) VALUES (?)');
		$query->bindValue(1, $imagen);
		$query->execute();	
	}

	echo "restart!";
?>