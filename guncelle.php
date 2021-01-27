<?php
	

	if(!isset($_GET['id']) || empty($_GET['id'])){
		header('Location:index.php');
		exit;
	}
	
	$sorgu=$db->prepare('select * from dersler 
		where id=? ');

			
	$sorgu->execute([
		$_GET['id']
	]);
	$ders=$sorgu->fetch(PDO::FETCH_ASSOC);
	
	if(!$ders){
		header('Location:index.php');
		exit;
	}
	
	$dersKategori=explode(',',$ders['kategori_id']);
	
	
	if(isset($_POST['submit'])){
		
		/*echo '<pre>';
		var_dump($_POST); die;*/
		$baslik=isset($_POST['baslik'])? $_POST['baslik']: $ders['id'];
		$icerik=isset($_POST['icerik'])? $_POST['icerik']: $ders['id'];
		$onay=isset($_POST['onay'])? $_POST['onay']: 0;
	 	$kategori_id=isset($_POST['kategori_id'])? $_POST['kategori_id']: null;
				
		if(!$baslik){
			echo 'Başlık Belirleyin!!!';
		}elseif(!$icerik){
			echo 'içerik Giriniz';	
		}elseif(!$kategori_id){
			echo 'kategori seçin';
		}else{
			$sorgu=$db->prepare('update dersler set
			baslik=?,
			icerik=?,
			onay=?,
			kategori_id=?,
			where id=?
			');
			
			$guncelle=$sorgu->execute([
				$baslik,
				$icerik,
				$onay,
				$kategori_id,
				$ders['id']
			]);
			
			if($guncelle){
				header('Location:index.php?sayfa=oku&id=' . $ders['id']);
			}else{
				echo 'günceleme işlemi başarısız';
			}
			
		}
	}
		

	
		$kategoriler=$db->query('select * from kategoriler order by ad asc ')->fetchAll(PDO::FETCH_ASSOC);



?>


			<form action='' method='post'>
				Başlık: <br>
				<input type='text' name='baslik' value="<?php echo isset($_POST['baslik']) ? $_POST['baslik']: $ders['baslik'] ?>"><br>
				İçerik: <br>
				<textarea name='icerik' cols='30' rows='10'value="<?php echo isset($_POST['icerik']) ? $_POST['icerik']: $ders['icerik'] ?>"></textarea><br>
				Kategori:<br>
				<select name='kategori_id[]' multiple size='5'>
					<option>--Kategoriler--</option>
					<?php foreach($kategoriler as $kategori):?>
					<option <?php echo in_array($kategori['id'],$dersKategori) ? 'selected':''?> value="<?php echo $kategori['id']?>"><?php echo $kategori['ad'];?></option>
					<?php endforeach ;?>
				</select><br>
				<select>
					<option <?php echo $ders['onay']== 1 ? 'selected': '' ?> value='1'>Onaylı</option>
					<option <?php echo $ders['onay']== 0 ? 'selected': '' ?> value='0'>Onaylı Değil</option>
				</select> <br>
				<input type='hidden' name='submit'>
				<button type='submit'>Güncelle</button>
			</form>		