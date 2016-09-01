<?php
	include_once('includes/connection.php');
	include_once('includes/image.php');
	require 'includes/Rating.php';

	$EA_id = base64_decode($_POST['dataA']);
	$EB_id = base64_decode($_POST['dataB']);

	if(isset($_POST['imageA']) or isset($_POST['imageA_x'])) {
		$results = sendRating($EA_id, $EB_id, 1, 0);
	}else if(isset($_POST['imageB']) or isset($_POST['imageB_x'])){
		$results = sendRating($EA_id, $EB_id, 0, 1);
	}

	update($EA_id, $EB_id, $results);

	header('Location: index.php');
?>