<?php

	

	if(!isset($_GET['id']) || empty($_GET['id'])){
		header('Lacotion:index.php');
		exit;
	}
	
	$sorgu=$db->prepare('delete from dersler where id=?');
	
	$sorgu->execute([
		$_GET['id']
	]);

		header('Location:index.php');
	







?>