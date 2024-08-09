<?php
    
    $id_user=$_GET['id_user'];
    $sql = $koneksi->query("select * from user where id_user='$id_user'");
    $data = $sql->fetch_assoc();

?>

<div class="panel panel-default">
<div class="panel-heading">
		EDIT USER
 </div> 
<div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <form method="POST" enctype="multipart/form-data" onsubmit="return validasi(this)" >
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" name="username" value="<?php echo $data['username'];?>" />
                                            
                                        </div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" name="pass" type="Password" id="pass" value="<?php echo $data['password'];?>"/>
                                            
                                        </div>

                                        
                                        <div class="form-group">
                                            <label>Level Akses</label>
                                            <input class="form-control" name="level"  id="pass" value="<?php echo $data['level'];?>" readonly/>
                                            
                                        </div>

                                       


                                        <div>
                                        	
                                        	<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                                        </div>
                                 </div>

                                 </form>
                              </div>
 </div>  
 </div>  
 </div>


 <?php

 	$username = $_POST ['username'];
 	$pass = $_POST ['pass'];
 
    $foto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    

 	$simpan = $_POST ['simpan'];


 	if ($simpan) {
        if (!empty($lokasi)) {
           
        $upload = move_uploaded_file($lokasi, "images/".$foto);
 		
 		$sql = $koneksi->query("update  user set username='$username', password='$pass' where id_user='$id_user'");

 		
 			?>
 				<script type="text/javascript">
 					
 					alert ("Data Berhasil Diubah");
 					window.location.href="?page=pengguna";

 				</script>
 			<?php
 		
 	}else{
        $sql = $koneksi->query("update  user set username='$username', password='$pass' where id_user='$id_user'");

        
            ?>
                <script type="text/javascript">
                    
                    alert ("Data Berhasil Diubah");
                    window.location.href="?page=pengguna";

                </script>
            <?php
    }

     }

 ?>
                             
                             

