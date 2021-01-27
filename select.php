		
	<h3>Ders Listesi</h3>	
		
	<form action="" method='get'>
		<input type='text' class="tarih" name='baslangic' value="<?php echo isset($_GET['baslangic']) ? $_GET['baslangic']:'' ?>" placeholder="Baslangic Tarihi ">
		<input type='text' class="tarih" name='bitis' value="<?php echo isset($_GET['bitis']) ? $_GET['bitis']:'' ?>" placeholder=" Bitis Tarihi "><br>
		<input type='text' name='arama'value="<?php echo isset($_GET['arama']) ? $_GET['arama']:'' ?>" placeholder="Derslerde Ara...">
		<button type='submit'>ARA</button>
	</form>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$('.tarih').datepicker({
			dateFormat:'yy-mm-dd'
		});
	</script>

<?php
	
	$where=[];	
	$sql='select dersler.id,dersler.baslik,group_concat(kategoriler.ad) as kategori_ad,group_concat(kategoriler.id)as kategori_id ,dersler.onay from dersler
		inner join kategoriler on find_in_set(kategoriler.id , dersler.kategori_id) ';
	
		if(isset($_GET['arama'])&& !empty($_GET['arama'])){
			$where[]= '( dersler.baslik like "%'.$_GET['arama'].'%")';
		}
		if(isset($_GET['baslangic'])&& !empty($_GET['baslangic'])&& isset($_GET['bitis'])&& !empty($_GET['bitis'])){
			$where[]='dersler.tarih between "'.$_GET['baslangic'].' 00:00:00"AND"'.$_GET['bitis'].' 23:59:59"';
		}
	
	if(count($where)>0){
		$sql .= ' where ' . implode('&&',$where);
	}	
	$sql .= 'GROUP BY dersler.id order by dersler.id desc';
		
		
		
	$dersler=$db->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
		//print_r($dersler);
	
	
?>
	
	<?php if($dersler): ?>
		
		<ul>
		<?php foreach($dersler as $ders): ?>
			<li>
				<?php echo $ders['baslik']; ?>
				<?php
				$kategoriAdlari=explode(',',$ders['kategori_ad']);
				$kategoriIdleri=explode(',',$ders['kategori_id']);
				foreach($kategoriAdlari as $key => $val){
					echo '<a href="?sayfa=kategori&id='.$kategoriIdleri[$key].'">'.$val.'</a>';
				}
				?>
				<div>
					<?php if($ders['onay']==1): ?>
					<a href="index.php?sayfa=oku&id=<?php echo $ders['id'];?>">[OKU]</a>
					<?php endif; ?>
					<a href="index.php?sayfa=guncelle&id=<?php echo $ders['id'];?>">[DUZENLE]</a>
					<a href="index.php?sayfa=sil&id=<?php echo $ders['id'];?>">[SIL]</a>
				</div>
			</li>
				<?php endforeach; ?>
		</ul>
	<?php else :?>
		<div>
			<?php if(isset($_GET['arama'])) :?>
				Aradiginiz kriterlere uygun ders bulunamadi
			<?php else :?>
				Henuz eklenmis veri yok
				<?php endif; ?>
		</div>
	<?php endif; ?>	
		








