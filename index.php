<?php
	include_once('includes/connection.php');
	include_once('includes/image.php');

	//store all images with fetch_all query
	$image = new Image;
	$images = $image->fetch_all();
	$EE = array_rand($images, 2);
	//check random
	$EE = check($EE);
	//vs
	$A = $images[$EE[0]];
	$B = $images[$EE[1]];
	//get Rank
	$sortedImages = $image->get_rank();
?>

<html>
<head>
	<!-- My Styles -->
	<link rel="stylesheet" href="assets/style.css" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		document.onkeydown = function(e){ 
			tecla = (document.all) ? e.keyCode : e.which;
			if (tecla = 116) return false
		}
	</script>
</head>
<body>
	<div class="container">
		<div class="images">
			<form action="rank.php" method="POST">
				<input type="image" src="<?php echo encode($A['image_path']); ?>" name="imageA" width="160" height="160">
				<input type="hidden" name="dataA" value="<?php echo base64_encode($A['image_id']); ?>" />
				<input type="image" src="<?php echo encode($B['image_path']); ?>" name="imageB" width="160" height="160">
				<input type="hidden" name="dataB" value="<?php echo base64_encode($B['image_id']); ?>" />
			</form>
		</div>
		<div class="rank">
			<ul>
				<?php 
					$counter = 1;
					for ($i = 0; $i < 5; $i++) { ?>
						<li>
							<strong><?php echo $counter; $counter++; ?></strong>
							<img src="<?php echo encode($sortedImages[$i]['image_path']); ?>">
							<br>
							<p><?php #echo $sortedImages[$i]['score']; ?></p>
						</li>
				<?php } ?>
			</ul>
		</div>

	</div>
</body>
</html>