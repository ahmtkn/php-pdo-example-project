<?php
	
	if(isset($_POST['ad'])){	
		if(empty($_POST['ad'])){
			echo 'kategori adını belirtiniz';
		}else{
			$ekle=$db->prepare('insert into kategoriler set
				ad=?
			');
			
			$sonuc=$ekle->execute([
				$_POST['ad']
			]);
			
			if($sonuc){
				header('Location:index.php?sayfa=kategoriler');
			}else{
				echo 'kategori eklenemedi';
			}
		}
		
	}

	


?>



	<form action="" method='post'>
		kategori adı:<br>
		<input type='text' name='ad'><br>
		<button type='submit'>Gönder</button>
	</form>