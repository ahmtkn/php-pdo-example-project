<?php
	
	if(!isset($_GET['id']) || empty($_GET['id'])){
		header('Location:?sayfa=kategoriler.php');
		exit;
	}else{
	
	$sorgu=$db->prepare('select * from kategoriler
	where id=?
	');
	
	$sorgu->execute([
		$_GET['id']
	]);
	}

	$kategori=$sorgu->fetch(PDO::FETCH_ASSOC);
	if(!$kategori){
		header('Location:?sayfa=kategoriler.php');
		exit;
	}

	
	
	
	
		$sonuc=$db->prepare('select * from dersler
			where find_in_set(?,kategori_id)
			order by id desc
		');
		
		$sonuc->execute([
			$kategori['id']
		]);
		
		$dersler=$sonuc->fetchAll(PDO::FETCH_ASSOC);			

?>

	<h3><?php echo $kategori['ad']?> Kategorisi </h3>
	<?php if($dersler): ?>
	<ul>
		<?php foreach($dersler as $ders){?>
			<li>
				<?php echo $ders['baslik']?>
				<div>
					<?php if($ders['onay']==1){?>
					<a href="?sayfa=oku&id=<?php echo $ders['id']?>">[OKU]</a>
					<?php } ?>
					<a href="?sayfa=guncelle&id=<?php echo $ders['id']?>">[DUZENLE]</a>
					<a href="?sayfa=sil&id=<?php echo $ders['id']?>">[SIL]</a>
				</div>
			
			</li>
		
		<?php } ?>
	</ul>
	<?php else : ?> 
		Bu kategoriye ait ders bulunmuyor
	<?php endif ?>
	
