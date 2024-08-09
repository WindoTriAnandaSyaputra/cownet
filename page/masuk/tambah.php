<?php

$koneksi = mysqli_connect("localhost", "u252328825_root", "e4E!lp3Scn$", "u252328825_dbcownet") or die("Gagal Koneksi");

function autoNumber($id, $table, $koneksi) {
    $query = "SELECT MAX(RIGHT($id, 3)) as max_id FROM $table";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    $id_max = $data['max_id'];
    $sort_num = (int) substr($id_max, 0, 3);
    $sort_num++;
    $new_code = sprintf("%03s", $sort_num);
    return $new_code;
}

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <font size="+2" face="arial" color="black"><b><center>TAMBAHKAN DEVICE</center></b></font>
    </div> 
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" onsubmit="return validasi(this)" enctype="multipart/form-data">
                    <div class="form-group">
                        <label></label>
                        <input name="id_masuk"  class="form-control" value="<?php echo autoNumber('id_masuk', 'masuk', $koneksi); ?>" />
                    </div>

                    <div class="form-group">
                        <label>Nama Device</label>
                        <input class="form-control" name="nama_device" id="nama_device" required />
                    </div>

                    <div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['simpan'])) {
    $id_masuk = $_POST['id_masuk'];
    $nama_device = $_POST['nama_device'];
    $id_keluar = $_POST['id_keluar'];

    $sql1 = $koneksi->query("INSERT INTO masuk (id_masuk, nama_device) VALUES ('$id_masuk', '$nama_device')");
    $sql2 = $koneksi->query("INSERT INTO keluar (id_masuk, id_keluar) VALUES ('$id_masuk', '$id_keluar')");

    {
        echo '<script type="text/javascript">';
        echo 'alert("Data Berhasil Disimpan");';
        echo 'window.location.href="?page=masuk";';
        echo '</script>';
    } 
}
?>
