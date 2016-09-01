<?php
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=facemash', 'root', '');
	} catch(PDOException $e) {
		exit('Error en la conexión');
	}
?>