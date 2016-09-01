<?php
	class Image {
		public function fetch_all() {
			global $pdo;

			$query = $pdo->prepare("SELECT * FROM images");
			$query->execute();

			return $query->fetchAll();
		}

		public function fetch_score(){
			global $pdo;

			$query = $pdo->prepare("SELECT score FROM images");
			$query->execute();

			return $query->fetchAll();	
		}

		public function fetch_score_id($image_id){
			global $pdo;

			$query = $pdo->prepare("SELECT score FROM images WHERE image_id = ?");
			$query->bindValue(1, $image_id);
			$query->execute();

			return $query->fetch();
		}

		public function fetch_path($image_id) {
			global $pdo;

			$query = $pdo->prepare("SELECT image_path FROM images WHERE image_id = ?");
			$query->bindValue(1, $image_id);
			$query->execute();

			return $query->fetch();
		}

		public function get_rank(){
			global $pdo;

			$query = $pdo->prepare('SELECT * FROM images ORDER BY score DESC');
			$query->execute();
			$sortedImages = $query->fetchAll();

			return $sortedImages;
		}
	}

	function encode($image){
		$actual_link = 'http://'.$_SERVER['HTTP_HOST'].'/FMC/';

		$path = $actual_link.'img/'.$image;
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$path = file_get_contents($path);
		$path = 'data:image/' . $type . ';base64,' . base64_encode($path);
		
		return $path;
	}

	function sendRating($EA_id, $EB_id, $EA_vote, $EB_vote){
		global $pdo;

		$scoreA = $pdo->prepare("SELECT score FROM images WHERE image_id = ?");
		$scoreA->bindValue(1, $EA_id);
		$scoreA->execute();
		$scoreA = $scoreA->fetch();

		$scoreB = $pdo->prepare("SELECT score FROM images WHERE image_id = ?");
		$scoreB->bindValue(1, $EB_id);
		$scoreB->execute();
		$scoreB = $scoreB->fetch();

		$rating = new Rating($scoreA['score'], $scoreB['score'], $EA_vote, $EB_vote);
		$results = $rating->getNewRatings();

		return $results;
	}

	function update($EA_id, $EB_id, $results){
		global $pdo;

		$query = $pdo->prepare('UPDATE images SET score = '.$results['a'].' WHERE image_id = ?');
		$query->bindValue(1, $EA_id);
		$query->execute();

		$query = $pdo->prepare('UPDATE images SET score = '.$results['b'].' WHERE image_id = ?');
		$query->bindValue(1, $EB_id);
		$query->execute();

	}

	function check($EE){
		if(isset($_COOKIE['A']) && isset($_COOKIE['B']) ) {
			if( $_COOKIE['A'] == $EE[0] && $_COOKIE['B'] == $EE[1]){
				unset($images[$EE[0]]);
				$EE = array_rand($images, 2);
			}
		}else{
			setcookie('A', $EE[0], time() + (86400 * 30), "/");
			setcookie('B', $EE[1], time() + (86400 * 30), "/");
		}

		setcookie('A', $EE[0], time() + (86400 * 30), "/");
		setcookie('B', $EE[1], time() + (86400 * 30), "/");

		return $EE;
	}
?>