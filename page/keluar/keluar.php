<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <font size="+2" face="arial" color="black"><b><center>DATA MONITORING SAPI</center></b></font>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <!-- Remove "Tambah Data" button for this view -->
                    <!-- <div>
                        <a href="?page=masuk&aksi=tambah" class="btn btn-danger" style="margin-top: 8px;"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div><br> -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr style="background:;color:black;">
                                <th>Id Device</th>
                                <th>Nama Device</th>
                                <th>Aktivitas</th> <!-- New Column -->
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $no = 2101081001;
                            $sql = $koneksi->query("SELECT * FROM masuk");

                            while ($data = $sql->fetch_assoc()) {

                            ?>

                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['nama_device']; ?></td>
                                <td>
                                    <?php if ($data['id_masuk'] == 2101081001): ?>
                                        <a href="?page=keluar&aksi=aktivitas1&id_masuk=<?php echo $data['id_masuk']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Aktivitas</a>
                                    <?php elseif ($data['id_masuk'] == 2101081002): ?>
                                        <a href="?page=keluar&aksi=aktivitas2&id_masuk=<?php echo $data['id_masuk']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Aktivitas</a>
                                    <?php elseif ($data['id_masuk'] == 2101081003): ?>
                                        <a href="?page=keluar&aksi=aktivitas3&id_masuk=<?php echo $data['id_masuk']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Aktvitas</a>
                                     <?php elseif ($data['id_masuk'] == 2101081004): ?>
                                        <a href="?page=keluar&aksi=aktivitas4&id_masuk=<?php echo $data['id_masuk']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Aktivitas</a>
                                    <?php elseif ($data['id_masuk'] == 2101081005): ?>
                                        <a href="?page=keluar&aksi=aktivitas5&id_masuk=<?php echo $data['id_masuk']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Aktivitas</a>    
                                    <?php else: ?>
                                        <!-- Tindakan default jika id_masuk tidak cocok dengan kondisi di atas -->
                                        <a href="?page=keluar&aksi=aksi_default&id_masuk=<?php echo $data['id_masuk']; ?>" class="btn btn-default"><i class="fa fa-edit"></i> Aksi Default</a>
                                    <?php endif; ?>
                                   
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id_masuk'])) {
    $id_masuk = $_GET['id_masuk'];
    $sql = $koneksi->query("DELETE FROM masuk WHERE id_masuk = '$id_masuk'");
    
    if ($sql) {
        echo '<script type="text/javascript">';
        echo 'alert("Data berhasil dihapus");';
        echo 'window.location.href="?page=masuk";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Gagal menghapus data");';
        echo 'window.location.href="?page=masuk";';
        echo '</script>';
    }
}
?>
