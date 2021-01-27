
	<a href="?sayfa=kategori_ekle">[Kategori ekle]</a>	
	
<?php
	$kategoriler=$db->query('select kategoriler.*,count(dersler.id) as toplamders from kategoriler 
	left join dersler on dersler.kategori_id= kategoriler.id
	group by kategoriler.id
	')->fetchAll(PDO::FETCH_ASSOC);

?>	

	<ul>
		<?php foreach($kategoriler as $kategori):?>
			<li>
			<a href="index.php?sayfa=kategori&id=<?php echo $kategori['id'];?>"</a>
				<?php echo $kategori['ad'];?>
				(<?php echo $kategori['toplamders'];?>)
			</li>
		<?php endforeach; ?>
	
	</ul>
	
	 