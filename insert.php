<?php
	
	if(isset($_POST['submit'])){
		$baslik=isset($_POST['baslik'])? $_POST['baslik']: null;
		$icerik=isset($_POST['icerik'])? $_POST['icerik']: null;
		$onay=isset($_POST['onay'])? $_POST['onay']: 0;
		$kategori_id=isset($_POST['kategori_id']) && is_array($_POST['kategori_id'])? implode(',',$_POST['kategori_id']): null;
		
		if(!$baslik){
			echo 'Kullanıcı adınız hatalı!!!';
		}else{
			$ekle=$db->prepare('insert into dersler set
				baslik=?,
				icerik=?,
				onay=?,
				kategori_id=?
				');
				
			$data=$ekle->execute([
				$baslik,
				$icerik,
				$onay,
				$kategori_id
			]);
			
			$sonId=$db->lastInsertId();
			
			if($data){
				header('Location:index.php?sayfa=oku&id'.$sonId);
			}else{	
				$hata=$ekle->errorInfo();
				echo 'MySQL Hatası:'. $hata[2];
			}
			
		}
		
	}

	$kategoriler=$db->query('select * from kategoriler order by ad asc ')->fetchAll(PDO::FETCH_ASSOC);
	
	
	



?>



		<form action='' method='post'>
				Başlık: <br>
				<input type='text' name='baslik'><br>
				İçerik: <br>
				<textarea name='icerik' cols='30' rows='10'></textarea><br>
				Kategori:<br>
				<select name="kategori_id[]" multiple size='5'>
					<?php foreach($kategoriler as $kategori):?>
					<option value="<?php echo $kategori['id']?>"><?php echo $kategori['ad'];?></option>
					<?php endforeach ;?>
				</select><br>
				<select name='onay'>
					<option value='1'>Onaylı</option>
					<option value='0'>Onaylı Değil</option>
				</select> <br>
				<input type='hidden' name='submit'>
				<button type='submit'>Gönder</button>
			</form>
					 
		
		