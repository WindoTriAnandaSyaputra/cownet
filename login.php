<?php
    error_reporting(E_ALL); // Aktifkan pelaporan kesalahan
    ini_set('display_errors', 1);

    session_start();

    $koneksi = new mysqli("localhost", "u252328825_root", "e4E!lp3Scn$", "u252328825_dbcownet");

    if(isset($_SESSION['admin']) || isset($_SESSION['user'])){
        header("location:index.php");
    } else {
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>COWNET</title>
    <link rel="icon" href="gambar/2.png">
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body {
            background: url(images/background.jpg) no-repeat fixed;
            -webkit-background-size: 100% 100%;
            -moz-background-size: 100% 100%;
            -o-background-size: 100% 100%;
            background-size: 100% 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                 <br />
            </div>
        </div>
         <div class="row ">
               <div align="center">
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                            
                            <div class="card-title center">
                            <img style="margin-left:15px; border-radius:7px" src="images/icon.png" class="img-thumbnail" width="150px" alt="">
 
                            </div>
                            <div class="panel-body">
                                <form role="form" method="POST">
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Username " name="nama" />
                                        </div>
                                                                              <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Password" name="pass" />
                                        </div>
                                
                                        <div class="form-group input-group">
                                            <input type="submit" class="btn btn-primary"  name="login" value="MASUK" />
                                        </div>
                                     
                                    
                                    </form>
                            </div>
                           
                        </div>
                    </div>
                
                
        </div>
    </div>


     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>

<?php

if (isset($_POST['login'])) {

    $nama = $_POST['nama'];
    $pass = $_POST['pass'];

    $ambil = $koneksi->query("SELECT * FROM user WHERE username='$nama' AND password='$pass'");
    $data = $ambil->fetch_assoc();
    $ketemu = $ambil->num_rows;

    if($ketemu >= 1) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['pass'] = $data['password'];
        $_SESSION['level'] = $data['level'];
    
        if($data['level'] == "admin") {
            $_SESSION['admin'] = $data['id_user'];
            header("location:index.php");
        } else if($data['level'] == "user") {
            $_SESSION['user'] = $data['id_user'];
            header("location:index.php");
        }
    } else {
        ?>
        <script type="text/javascript">
            alert("Username dan Password Anda Salah");
        </script>
        <?php
    }
}
}
?>

