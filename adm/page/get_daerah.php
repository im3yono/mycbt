<?php 
// include_once("../../config/server.php");

$data = $_POST['data'];
$id = $_POST['id'];

// $n=strlen($id);
// $m=($n==2?5:($n==5?8:13));
// $wil=($n==2?'Kota/Kab':($n==5?'Kecamatan':'Desa/Kelurahan'));

if($data == "kabupaten"){
	?>
	Kabupaten/Kota
	<select id="form_kab">
		<option value="">Pilih Kabupaten/Kota</option>
		<?php 
		$daerah = mysqli_query($koneksi,"SELECT * FROM lok_cities WHERE prov_id='$id' ORDER BY city_name");

		while($d = mysqli_fetch_array($daerah)){
			?>
			<option value="<?php echo $d['city_id']; ?>"><?php echo $d['city_name']; ?></option>
			<?php 
		}
		?>
	</select>

	<?php 
}else if($data == "kecamatan"){ 
	?>
	<select id="form_kec">
		<option value="">Pilih Kecamatan</option>
		<?php 
		$daerah = mysqli_query($koneksi,"SELECT * FROM lok_districts WHERE city_id='$id' ORDER BY dis_name");

		while($d = mysqli_fetch_array($daerah)){
			?>
			<option value="<?php echo $d['dis_id ']; ?>"><?php echo $d['dis_name']; ?></option>
			<?php 
		}
		?>
	</select>

	<?php 
}else if($data == "desa"){ 
	?>

	<select id="form_kel">
		<option value="">Pilih Desa</option>
		<?php 
		$daerah =mysqli_query($koneksi,"SELECT * FROM lok_subdistricts WHERE dis_id='$id' ORDER BY subdis_name");
		while($d = mysqli_fetch_array($daerah)){
			?>
			<option value="<?php echo $d['subdis_id']; ?>"><?php echo $d['subdis_name']; ?></option>
			<?php 
		}
		?>
	</select>

	<?php 

}
?>