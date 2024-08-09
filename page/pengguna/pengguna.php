<div class="row">
<div class="col-md-12">
<!-- Advanced Tables -->
<div class="panel panel-default">
    <div class="panel-heading">
         Data Admin
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <br>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Level</th>
                        
                        <th width="19%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                        $no = 1;

                        $sql = $koneksi->query("select * from user ");

                        while ($data= $sql->fetch_assoc()) {       
                       
                    ?>

                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['username'];?></td>
                        <td><?php echo $data['level'];?></td>
                       
                         <td>
                            <a href="?page=pengguna&aksi=ubah&id_user=<?php echo $data['id_user']; ?>" class="btn btn-warning" ><i class="fa fa-edit"></i> Ubah</a>
                          

                        </td>
                    </tr>


                    <?php  } ?>
                </tbody>

                </table>
              </div>
    </div>
 </div>
</div>
</div>                          