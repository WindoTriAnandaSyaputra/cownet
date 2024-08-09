<?php
	
	$id_masuk = $_GET ['id_masuk'];

	$koneksi->query("delete from masuk
	where id_masuk ='$id_masuk'");

?>


<script type="text/javascript">
		window.location.href="?page=masuk";
</script>